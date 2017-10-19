<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use URL;
use App\Notifications\UserRegistered;
use App\UserData;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;
use App\CLPWallet;

/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
class ActiveController extends Controller
{
    const COINBASE = 'coinbase';
    /*
    author huynq
    active Acc with email
    */
    public function activeAccount(Request $request, $infoActive = "" ){
        //chay sang trng hom neu da login
        if(Auth::user()){
            return redirect("home");
        }

        if ( strlen( $infoActive ) > 0 ){
            $data = json_decode( base64_decode( $infoActive ) );
            //check neu da active roi va chua login hien thong bao da active kem link login
            $activeUser = User::where('email', '=', $data[1])->first();
            if($activeUser && $activeUser->active == 1 ) {
                //chay sang trang thong bao
                return redirect("notification/useractived");
            }
            
            $count = User::where('email','=', $data[1])
                            ->where('updated_at','>', Carbon::now()->subDay(3))
                            ->count();
            if($count==0){
                $request->session()->flash('error', 'Link Active Account expired!');
            }else{
                //kiem tra va update kich hoat tk
                if ( $data[0] == hash( "sha256", md5( md5( $data[1] ) ) ) ) {
                    try {
                        $user = User::where( 'email', '=', $data[1] )->first();
                        
                        //Active vaf redirect ve trang thong bao kem theo link login
                        if($user){
                            if($user->name) {
                                //$accountWallet = $this->GenerateWallet(self::COINBASE,$user->name);
                                $accountWallet = $this->GenerateAddress(self::COINBASE, $user->name);
                            }
                            
                            if(!$accountWallet){
                                return false;
                            }

                            $user->active = 1;
                            $user->save();
                            UserData::find($user->id )->update( ['active' => 1] );

                            $userCoin = $user->userCoin;
                            $userCoin->accountCoinBase = $accountWallet['accountId'];
                            $userCoin->walletAddress = $accountWallet['walletAddress'];
                            $userCoin->save();

                            User::updateUserGenealogy($user->id);
                            return redirect("notification/useractive");
                        }else{
                            $request->session()->flash('error', 'Cannot activate !');
                        }
                    } catch ( Exception $e ) {
                        throw $e;
                    }
                } else {
                    $request->session()->flash('error', 'Something wrongs. We cannot activated!');
                }
            }

        } else {
            $request->session()->flash('error', 'Something wrongs. We cannot activated!');
        }
        return view('adminlte::auth.reactive');
    }
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
                echo "Not select wallet yet";
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

    public function reactiveAccount(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'email' => 'required|email',
            ]);
            $email = $request->email;
            $count = User::where('email', '=', $email)->count();
            if ($count == 0) {
                $request->session()->flash('error', 'Email not exits!');
            } else {
                $user = User::where('email', '=', $email)->first();
                $user->updated_at = date('Y-m-d H:i:s');
                $user->save();
                UserData::find($user->id )->update( ['active' => 1] );
                $encrypt = [hash("sha256", md5(md5($email))), $email];
                $linkActive = URL::to('/active') . "/" . base64_encode(json_encode($encrypt));
                $user->notify(new UserRegistered($user, $linkActive));
                $request->session()->flash('status', 'We have sent you an email to activate account. Please check your email!');
            }
        }
        return view('adminlte::auth.reactive');
    }

}

