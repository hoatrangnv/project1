<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Google2FA;
use Session;
use App\User;

class LoginController extends Controller{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        attemptLogin as attemptLoginAtAuthenticatesUsers;
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(){
        return view('adminlte::auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function username(){
        return config('auth.providers.users.field', 'email');
    }

    protected function attemptLogin(Request $request){
        if($this->username() === 'email'){
            return $this->attemptLoginAtAuthenticatesUsers($request);
        }
        if(!$this->attemptLoginAtAuthenticatesUsers($request)){
            return $this->attempLoginUsingUsernameAsAnEmail($request);
        }
        return false;
    }

    protected function validateLogin(Request $request){
        $this->validate($request, [
            $this->username() => 'required|exists:users,' . $this->username() . ',active,1',
            'password' => 'required|string',
            'g-recaptcha-response' => config('app.enable_captcha') ? 'required|captcha' : '',
        ], [
            $this->username() . '.exists' => 'The selected email is invalid or the account is not active.'
        ]);
    }

    protected function attempLoginUsingUsernameAsAnEmail(Request $request){
        return $this->guard()->attempt(
            [
                'email' => $request->input('username'),
                'password' => $request->input('password')
            ],
            $request->has('remember'));
    }

    protected function authenticated(Request $request, $user){
        if($request->session()->has('google2fa') && $request->session()->get('google2fa') === true){
        }else{
            if($user->is2fa){
                $request->session()->put('authy:auth:id', $user->id);
                $request->session()->put('authy:auth:email', $request->email);
                $request->session()->put('authy:auth:password', $request->password);
                $request->session()->put('authy:auth:remember', $request->remember);
                $request->session()->put('authy:auth:2fa', $user->google2fa_secret);
                $this->guard()->logout();
                return redirect('/authenticator');
            }
        }
    }

    public function auth2fa(Request $request){
        if(Session::get('google2fa'))
            return redirect('/home');
        $valid = true;
        if($request->isMethod('post')){
            $key = Session::get('authy:auth:2fa');
            $code = $request->get('code');
            if(!$code){
                $valid = false;
            }else{
                $valid = Google2FA::verifyKey($key, $code);
                if($valid){
                    if(Session::get('authy:auth:id')){
                        $user = User::findOrFail(
                            Session::get('authy:auth:id')
                        )->toArray();
                        if($user){
                            $user = [
                                'email' => Session::get('authy:auth:email'),
                                'password' => Session::get('authy:auth:password')
                            ];
                            $this->guard()->attempt(
                                $user, Session::get('authy:auth:remember')
                            );
                            Session::put('google2fa', true);
                            return redirect('home');
                        }
                    }
                    return redirect(url('login'));
                }
            }
        }
        if(Session('authy:auth:id')){
            return view('adminlte::auth.authenticator')->with(compact('valid'));
        }else{
            redirect(url('login'));
        }
    }
}
