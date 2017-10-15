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

/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
class TestRegisterController extends Controller
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
    public function showRegistrationFormNoActive(Request $request)
    {
        $lstCountry = array("0" => 'Choose a country',"4" => "Afghanistan","248" => "Aland Islands","8" => "Albania","12" => "Algeria","16" => "American Samoa","20" => "Andorra","24" => "Angola","660" => "Anguilla","10" => "Antarctica","28" => "Antigua and Barbuda","32" => "Argentina","51" => "Armenia","533" => "Aruba","36" => "Australia","40" => "Austria","31" => "Azerbaijan","44" => "Bahamas","48" => "Bahrain","50" => "Bangladesh","52" => "Barbados","112" => "Belarus","56" => "Belgium","84" => "Belize","204" => "Benin","60" => "Bermuda","64" => "Bhutan","68" => "Bolivia, Plurinational State of","535" => "Bonaire, Sint Eustatius and Saba","70" => "Bosnia and Herzegovina","72" => "Botswana","74" => "Bouvet Island","76" => "Brazil","86" => "British Indian Ocean Territory","96" => "Brunei Darussalam","100" => "Bulgaria","854" => "Burkina Faso","108" => "Burundi","116" => "Cambodia","120" => "Cameroon","124" => "Canada","132" => "Cape Verde","136" => "Cayman Islands","140" => "Central African Republic","148" => "Chad","152" => "Chile","156" => "China","162" => "Christmas Island","166" => "Cocos (Keeling) Islands","170" => "Colombia","174" => "Comoros","178" => "Congo","180" => "Congo, the Democratic Republic of the","184" => "Cook Islands","188" => "Costa Rica","384" => "Côte d'Ivoire","191" => "Croatia","192" => "Cuba","531" => "Curaçao","196" => "Cyprus","203" => "Czech Republic","208" => "Denmark","262" => "Djibouti","212" => "Dominica","214" => "Dominican Republic","218" => "Ecuador","818" => "Egypt","222" => "El Salvador","226" => "Equatorial Guinea","232" => "Eritrea","233" => "Estonia","231" => "Ethiopia","238" => "Falkland Islands (Malvinas)","234" => "Faroe Islands","242" => "Fiji","246" => "Finland","250" => "France","254" => "French Guiana","258" => "French Polynesia","260" => "French Southern Territories","266" => "Gabon","270" => "Gambia","268" => "Georgia","276" => "Germany","288" => "Ghana","292" => "Gibraltar","300" => "Greece","304" => "Greenland","308" => "Grenada","312" => "Guadeloupe","316" => "Guam","320" => "Guatemala","831" => "Guernsey","324" => "Guinea","624" => "Guinea-Bissau","328" => "Guyana","332" => "Haiti","334" => "Heard Island and McDonald Islands","336" => "Holy See (Vatican City State)","340" => "Honduras","344" => "Hong Kong","348" => "Hungary","352" => "Iceland","356" => "India","360" => "Indonesia","364" => "Iran, Islamic Republic of","368" => "Iraq","372" => "Ireland","833" => "Isle of Man","376" => "Israel","380" => "Italy","388" => "Jamaica","392" => "Japan","832" => "Jersey","400" => "Jordan","398" => "Kazakhstan","404" => "Kenya","296" => "Kiribati","408" => "Korea, Democratic People's Republic of","410" => "Korea, Republic of","414" => "Kuwait","417" => "Kyrgyzstan","418" => "Lao People's Democratic Republic","428" => "Latvia","422" => "Lebanon","426" => "Lesotho","430" => "Liberia","434" => "Libya","438" => "Liechtenstein","440" => "Lithuania","442" => "Luxembourg","446" => "Macao","807" => "Macedonia, the former Yugoslav Republic of","450" => "Madagascar","454" => "Malawi","458" => "Malaysia","462" => "Maldives","466" => "Mali","470" => "Malta","584" => "Marshall Islands","474" => "Martinique","478" => "Mauritania","480" => "Mauritius","175" => "Mayotte","484" => "Mexico","583" => "Micronesia, Federated States of","498" => "Moldova, Republic of","492" => "Monaco","496" => "Mongolia","499" => "Montenegro","500" => "Montserrat","504" => "Morocco","508" => "Mozambique","104" => "Myanmar","516" => "Namibia","520" => "Nauru","524" => "Nepal","528" => "Netherlands","540" => "New Caledonia","554" => "New Zealand","558" => "Nicaragua","562" => "Niger","566" => "Nigeria","570" => "Niue","574" => "Norfolk Island","580" => "Northern Mariana Islands","578" => "Norway","512" => "Oman","586" => "Pakistan","585" => "Palau","275" => "Palestinian Territory, Occupied","591" => "Panama","598" => "Papua New Guinea","600" => "Paraguay","604" => "Peru","608" => "Philippines","612" => "Pitcairn","616" => "Poland","620" => "Portugal","630" => "Puerto Rico","634" => "Qatar","638" => "Réunion","642" => "Romania","643" => "Russian Federation","646" => "Rwanda","652" => "Saint Barthélemy","654" => "Saint Helena, Ascension and Tristan da Cunha","659" => "Saint Kitts and Nevis","662" => "Saint Lucia","663" => "Saint Martin (French part)","666" => "Saint Pierre and Miquelon","670" => "Saint Vincent and the Grenadines","882" => "Samoa","674" => "San Marino","678" => "Sao Tome and Principe","682" => "Saudi Arabia","686" => "Senegal","688" => "Serbia","690" => "Seychelles","694" => "Sierra Leone","702" => "Singapore","534" => "Sint Maarten (Dutch part)","703" => "Slovakia","705" => "Slovenia","90" => "Solomon Islands","706" => "Somalia","710" => "South Africa","239" => "South Georgia and the South Sandwich Islands","728" => "South Sudan","724" => "Spain","144" => "Sri Lanka","729" => "Sudan","740" => "Suriname","744" => "Svalbard and Jan Mayen","748" => "Swaziland","752" => "Sweden","756" => "Switzerland","760" => "Syrian Arab Republic","158" => "Taiwan, Province of China","762" => "Tajikistan","834" => "Tanzania, United Republic of","764" => "Thailand","626" => "Timor-Leste","768" => "Togo","772" => "Tokelau","776" => "Tonga","780" => "Trinidad and Tobago","788" => "Tunisia","792" => "Turkey","795" => "Turkmenistan","796" => "Turks and Caicos Islands","798" => "Tuvalu","800" => "Uganda","804" => "Ukraine","784" => "United Arab Emirates","826" => "United Kingdom","840" => "United States","581" => "United States Minor Outlying Islands","858" => "Uruguay","860" => "Uzbekistan","548" => "Vanuatu","862" => "Venezuela, Bolivarian Republic of","704" => "Viet Nam","92" => "Virgin Islands, British","850" => "Virgin Islands, U.S.","876" => "Wallis and Futuna","732" => "Western Sahara","887" => "Yemen","894" => "Zambia","716" => "Zimbabwe");
        $referrerId = $referrerName = null;
        if(isset($request['referrer']) && trim($request['referrer']) != ''){
            $request['referrer'] = trim($request['referrer']);
            if(is_numeric($request['referrer']) && $request['referrer'] > 0) {
                $user = User::find($request['referrer']);
            }elseif(is_string($request['referrer'])){
                $user = User::where('name', '=', $request['referrer'])->first();
            }
            if($user){
                $referrerId = $user->id;
                $referrerName = $user->name;
            }
        }
        return view('adminlte::auth.test_register', ['lstCountry'=>$lstCountry, 'referrerId' =>$referrerId, 'referrerName' => $referrerName]);
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
            'name'     => 'required|without_spaces|max:255|unique:users,name',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|confirmed',
            //'password' => 'required|min:8|confirmed|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/',
            'phone'    => 'required',
            'terms'    => 'required',
            'country'    => 'required|not_in:0',
            'g-recaptcha-response'=> config('app.enable_captcha') ? 'required|captcha' : '',
        ]);
    }
    

    public function registerNoActive(Request $request)
    {
        //$this->validator($request->all())->validate();

        event(new Registered($user = $this->createNoActive($request->all())));

        if($user == false) flash()->success('Dont have sponsor id.');
        else flash()->success('User has been created.');

        return redirect()->route('test.showRegister');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function createNoActive(array $data)
    {
        //Tao acc vi
        try {
            //Tạo tk 
            // if($data['name']) {
            //     $accountWallet = $this->GenerateWallet(self::COINBASE,$data['name']);
            // }
            
            // if(!$accountWallet){
            //     return false;
            // }
            //get userid from uid
            $userReferer = User::where('uid', $data['refererId'])->get()->first();

            if(!isset($userReferer->id)) return false;

            //luu vao thong tin ca nhan vao bang User
            $fields = [
                'firstname'     => $data['name'],
                'lastname'     => 'Do',
                'name'     => $data['name'],
                'email'    => $data['name'] . '@gmail.com',
                'phone'    => '0978788999',
                'country'    => '704',
                'refererId'    => isset($userReferer->id) ? $userReferer->id : null,
                'password' => bcrypt('1'),
                //'accountCoinBase' => 'test',
                'active' => 1,
                'activeCode' => 'test',
                'uid' => User::getUid(),
                'google2fa_secret' => Google2FA::generateSecretKey(16)
            ];
            if (config('auth.providers.users.field','email') === 'username' && isset($data['username'])) {
                $fields['username'] = $data['username'];
            }
            $user = User::create($fields);

            //SAVE to User_datas
            $fields['userId'] = $user->id;
            
            $fields['clpCoinAmount'] = '20000';
            
            $userData = UserData::create($fields);

            //Luu thong tin ca nhan vao bang user_coin
            //$fields['backupKey'] = $backupKey;
             $fields['accountCoinBase'] = 'test';
             $fields['walletAddress'] = 'test';
            $userCoin = UserCoin::create($fields);

            //Update calculate total member
            User::updateUserGenealogy($user->id);

            //gui mail
            //ma hoa send link active qua mail
            // if($user) {
            //     $encrypt    = [hash("sha256", md5(md5($data['email']))),$data['email']];
            //     $linkActive =  URL::to('/active')."/".base64_encode(json_encode($encrypt));
            //     $user->notify(new UserRegistered($user, $linkActive));  
            // }
            return $user;
        } catch (Exception $e) {
            var_dump($e->getmessage());
        }
    }
}
