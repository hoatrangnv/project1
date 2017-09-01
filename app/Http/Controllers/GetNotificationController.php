<?php

namespace App\Http\Controllers;

use App\UserCoin;
use Illuminate\Http\Request;

use App\User;
use App\Wallet;
use App\Withdraw;
use Auth;
use Session;
use Validator;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;

class GetNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getNotification(){
        // 46345ee6-eff5-5ef5-9fa2-3dc37255dbed
        // 7e9134cc-1c34-5156-a296-4eba995a51b2
        // $currentuserid = Auth::user()->id;
        // $user = UserCoin::findOrFail($currentuserid);
        // $contact= $client->getAccount($user->accountCoinBase);
        // $nome = 'name_for_address';
        // $endereco= new Address(['name' => $nome]);
        // $client->createAccountAddress($contact, $endereco);
        // dd($user->accountCoinBase);
        // dd($currentuserid);
        $configuration = Configuration::apiKey(config('app.coinbase_key'), config('app.coinbase_secret'));
        $client = Client::create($configuration);

        // $contaID = 'accountID'
        // $conta= $client->getAccount("92896cd8-db47-5f21-913b-e4e8dc302bec");
        // $nome = 'name_for_address';
        // $endereco= new Address(['name' => $nome]);
        // $client->createAccountAddress($conta, $endereco);

        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.coinbase.com/v2/notifications",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: 8aNbvDlYDlVGvr2o JpLGCFU5OapYUYN3EEy1UxpG75NfrKEq",
    "cache-control: no-cache"
  ),
));
curl https://api.coinbase.com/v2/notifications \
  -H 'Authorization: 8aNbvDlYDlVGvr2o JpLGCFU5OapYUYN3EEy1UxpG75NfrKEq'
$response = curl_exec($curl);
dd($response);
$err = curl_error($curl);

curl_close($curl);


        // $address = new Address([
        //     'name' => 'New Address'
        // ]);
        // $account = $client->getAccount("3ac91e09-1693-5d4e-adc2-61fee7943c6a");  
        // $addresses = $client->createAccountAddress($account, $address);
        // dd($addresses);     
        // $account = $client->getAccount("3ac91e09-1693-5d4e-adc2-61fee7943c6a");                    
        // $addressId = $client->getAccountAddresses($account);
        // dd($addressId);                    
        // $addresses = $client->getAccountAddress($account, $addressId->getFirstId());                   
        // $walletAddress = json_encode($addresses->getAddress());

        // $account = $client->getAccount("4361ab31-69a6-52bd-8e18-b91924a7633c");
        // dd($account);
        // $account = $client->getAccount($user->accountCoinBase);
        // $addressId = $client->getAccountAddresses($account);

        // dd($walletAddress);
        //$addresses = $client->getAccountAddress($account, $addressId->getFirstId());
        dd($client->getAccounts());
        // dd($client->getAddresses());
        // dd($client->getAccountTransactions($account));
        dd($client->getNotifications());



        // 28985760-94fa-597d-b8b6-983aad9c804b
        // if($request->ajax()) {
        //     if(isset($request['action']) && $request['action'] == 'btc') {
        //         $currentuserid = Auth::user()->id;
        //         $user = UserCoin::findOrFail($currentuserid);
        //         if ($user->walletAddress == '' && $user->accountCoinBase != '') {
        //             $configuration = Configuration::apiKey(config('app.coinbase_key'), config('app.coinbase_secret'));
        //             $client = Client::create($configuration);
        //             $account = $client->getAccount($user->accountCoinBase);
        //             $addressId = $client->getAccountAddresses($account);
        //             $addresses = $client->getAccountAddress($account, $addressId->getFirstId());
        //             $walletAddress = json_encode($addresses->getAddress());
        //             if ($walletAddress != '') {
        //                 $user->walletAddress = $walletAddress;
        //                 $user->save();
        //             }
        //         }
        //         return response()->json(array('walletAddress' => $user->walletAddress));
        //     }
        // }
        // die();
    }

}
