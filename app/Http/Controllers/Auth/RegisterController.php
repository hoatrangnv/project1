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
use App\CLPWallet;
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

        Validator::extend('non_utf8', function($attr, $value){
            if(mb_detect_encoding($value) == 'UTF-8') return false;
            else return true;
        });

        $customeMessage = [
                'firstname.required' => 'First Name is required',
                'lastname.required' => 'Last Name is required',
                'name.required' => 'User Name is required',
                'name.unique' => 'User Name has already been taken',
                'email.required' => 'Email is required',
                'email.unique' => 'Email has already been taken',
                'password.required' => 'Password is required',
                'phone.required' => 'Phone is required',
                'terms.required' => 'Please check term and conditions',
                'name.without_spaces' => 'User Name cannot have spaces',
                'name.non_utf8' => 'User Name accept Latin characters only',
                'g-recaptcha-response.required' => 'Captcha is required'
                ];

        return Validator::make($data, [
            'firstname'     => 'required|max:255',
            'lastname'     => 'required|max:255',
            'name'     => 'required|without_spaces|non_utf8|min:3|max:255|unique:users,name',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'name_country' => 'required',
            'phone'    => 'required',
            'terms'    => 'required',
            'refererId'    => 'required',
            'country'    => 'required|not_in:0',
            'g-recaptcha-response'=> config('app.enable_captcha') ? 'required|captcha' : '',
        ], $customeMessage);
    }
    
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

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
                echo "Net select wallet yet";
        }
    }

    /*
    * @author GiangDT
    * 
    * Generate new address
    *
    */
    private function GenerateAddress( $type, $name = null ) {
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

                //Account detail
                $account = $client->getAccount(config('app.coinbase_account'));

                // Generate new address and get this adress
                $address = new Address([
                    'name' => $name
                ]);

                //Generate new address
                $client->createAccountAddress($account, $address);

                //Get all address
                $listAddresses = $client->getAccountAddresses($account);

                $address = '';
                $id = '';
                foreach($listAddresses as $add) {
                    if($add->getName() == $name) {
                        $address = $add->getAddress();
                        $id = $add->getId();
                        break;
                    }
                }

                $data = [ "accountId" => $id,
                    "walletAddress" => $address ];

                return $data;
            default:
                throw new \Exception("Not select type of api yet");
                
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
            if($currentDate <= $secondSaleEnd) {
                $active = 1;
            }
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
            //$fields['walletAddress'] = $accountWallet['walletAddress'];
            $userData = UserData::create($fields);

            if($currentDate <= $secondSaleEnd) {
                $accountWallet = $this->GenerateAddress(self::COINBASE, $user->name);
                $fields['accountCoinBase'] = $accountWallet['accountId'];
                $fields['walletAddress'] = $accountWallet['walletAddress'];

                User::updateUserGenealogy($user->id);
            }
            //Luu thong tin ca nhan vao bang user_coin
            //$fields['backupKey'] = $backupKey;
            $userCoin = UserCoin::create($fields);

            //gui mail
            //ma hoa send link active qua mail
            //in private sale don't send active email

            if($currentDate > $secondSaleEnd) {
                if($user) {
                    $encrypt    = [hash("sha256", md5(md5($data['email']))),$data['email']];
                    $linkActive =  URL::to('/active')."/".base64_encode(json_encode($encrypt));
                    $user->notify(new UserRegistered($user, $linkActive));
                }
            }

            return $user;
        } catch (Exception $e) {
            Session()->flash('error', 'Register Account is not success!');
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
