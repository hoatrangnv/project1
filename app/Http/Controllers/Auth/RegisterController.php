<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Google2FA;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
//use App\BitGo\BitGoSDK;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;
use Illuminate\Auth\Events\Registered;
use App\Notifications\UserRegistered;
use App\UserData;
use App\UserCoin;
use URL;
use Session;

/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    const COINBASE = 'coinbase';
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        $refererId = $referrerName = null;
        $user = User::where('name', '=', config('app.user_referral_register'))->first();
        if($user){
            $refererId = $user->uid;
            $referrerName = $user->name;
        }

        return view('adminlte::auth.register', ['refererId' =>$refererId, 'referrerName' => $referrerName]);
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/notiactive';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        return Validator::make($data, [
            'firstname'     => 'required|max:255',
            'lastname'     => 'required|max:255',
            'name'     => 'required|without_spaces|min:3|max:255|unique:users,name',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'name_country' => 'required',
            //'password' => 'required|min:8|confirmed|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/',
            'phone'    => 'required',
            'terms'    => 'required',
            'refererId'    => 'required',
            'country'    => 'required|not_in:0',
            'g-recaptcha-response'=> config('app.enable_captcha') ? 'required|captcha' : '',
        ]);
    }
    
    public function register(Request $request)
    {
        //$this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));


        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
    /**
     * Generate a new Account Coinbase.
     * @param  array  $data
     * @return User
     */
    private function GenerateWallet( $type, $name = null ) {
        $data = [];
        switch ($type) {
            case "bitgo":
                $bitgo = new BitGoSDK();
                $bitgo->authenticateWithAccessToken(config('app.bitgo_token'));
                $wallet = $bitgo->wallets();
                //set mat khau mac dinh
                $createWallet = $wallet->createWallet($data['email'],config('app.bitgo_password'),"keyternal");
                $addressWallet = $idWallet = $createWallet['wallet']->getID();
                //backup key ...
                $backupKey = json_encode($createWallet);
                //add hook ...
                $wallet = $bitgo->wallets()->getWallet($idWallet);
                $createWebhook = $wallet->createWebhook("transaction",config('app.bitgo_hook'));
                return $data = [ 'idWallet' => $idWallet ];
            case self::COINBASE:
                // tạo acc ví cho tk
                $configuration = Configuration::apiKey( config('app.coinbase_key'), config('app.coinbase_secret'));
                $client = Client::create($configuration);
                $account = new Account([
                    'name' => $name
                ]);
                $client->createAccount($account);
                $accountId = $account->getId();
          
                // tạo địa chỉ ví || get địa chỉ ví
                $account = $client->getAccount($accountId);
                $address = new Address([
                    'name' => $name
                ]);
                $client->createAccountAddress($account, $address);

                $addressId = $client->getAccountAddresses($account);
                $addresses = $client->getAccountAddress($account, $addressId->getFirstId());

                $data = [ "accountId" => $accountId,
                          "walletAddress" => $addresses->getAddress() ];
                return $data;
            default:
                echo "chưa chọn lựa loại ví";
        }
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        //Tao acc vi
        try {
            //get userid from uid
            $userReferer = User::where('uid', $data['refererId'])->get()->first();

            $currentDate = date('Y-m-d');
            $secondSaleEnd = date('Y-m-d', strtotime(config('app.second_private_end')));

            $active = 0;
            if($currentDate <= $secondSaleEnd) $active = 1;
            //luu vao thong tin ca nhan vao bang User
            $fields = [
                'firstname'     => $data['firstname'],
                'lastname'     => $data['lastname'],
                'name'     => $data['name'],
                'email'    => $data['email'],
                'phone'    => $data['phone'],
                'country'    => $data['country'],
                'name_country' => $data['name_country'],
                'refererId'    => isset($userReferer->id) ? $userReferer->id : null,
                'password' => bcrypt($data['password']),
                //'accountCoinBase' => $accountWallet['accountId'],
                'status' => 0,
                'active' => $active,
                'activeCode' => md5($data['email']),
                'uid' => User::getUid(),
                'google2fa_secret' => Google2FA::generateSecretKey(16)
            ];
            if (config('auth.providers.users.field','email') === 'username' && isset($data['username'])) {
                $fields['username'] = $data['username'];
            }

            $user = User::create($fields);

            //SAVE to User_datas
            $fields['userId'] = $user->id;
            if($userReferer->name == config('app.root_name')) {
                $fields['isBinary'] = 1;
            }
            //$fields['walletAddress'] = $accountWallet['walletAddress'];
            $userData = UserData::create($fields);

            //Luu thong tin ca nhan vao bang user_coin
            //$fields['backupKey'] = $backupKey;
            $userCoin = UserCoin::create($fields);

            //gui mail
            //ma hoa send link active qua mail
            //in private sale don't send active email

            if($currentDate <= $secondSaleEnd) {
                if($user) {
                    $encrypt    = [hash("sha256", md5(md5($data['email']))),$data['email']];
                    $linkActive =  URL::to('/active')."/".base64_encode(json_encode($encrypt));
                    $user->notify(new UserRegistered($user, $linkActive));
                }
            }

            return $user;
        } catch (Exception $e) {
            Session()->flash('error', 'Register Account not successfully!');
            \Log::error('Running RegisterController has error: ' . date('Y-m-d') .$e->getMessage());
        }
    }
    /** 
     * @author huynq
     * @param type $username
     * @return type
     */
    public function registerWithRef($nameRef){
        if($nameRef){
           $data = User::select("uid")->where('name', $nameRef)->first();
           if ( $data ) {
               $referrerId = $data->uid;
               $referrerName = $nameRef;
               return view('adminlte::auth.subregister', ['referrerId' =>$referrerId, 'referrerName' => $referrerName]);
           }else{
               return redirect("register");
           }
        }else{
            return redirect("register");
        }
    }
}
