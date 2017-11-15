<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Google2FA;
use Illuminate\Support\Facades\Auth;
use Session;

use App\User;

class LoginController extends Controller{
    //use ThrottlesLogins;

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
    //protected $redirectTo = '/home';

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

    protected function redirectTo()
    {
        $user = Auth::user();
        if (count(User::userHasRole(User::where('email', $user->email)->pluck("id")[0])) > 0 ){
            $this->redirectTo = '/admin/home';
            return '/admin/home';
        }

        $this->redirectTo = '/home';
        return '/home';
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

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $minutes = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $minutes = $minutes / 60;

        $message = trans('auth.throttle', ['minutes' => $minutes]);

        $errors = [$this->username() => $message];

        if ($request->expectsJson()) {
            return response()->json($errors, 423);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), 5, 30
        );
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

    public function redirectWithAdmin($email){
        if (count(User::userHasRole(User::where('email', $email)->pluck("id")[0])) > 0 ){
            $this->redirectTo = '/admin/home';
            return redirect(url('/admin/home'));
        }

        $this->redirectTo = '/home';
        return redirect(url('/home'));
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

                            return $this->redirectWithAdmin(Session::get('authy:auth:email'));
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
