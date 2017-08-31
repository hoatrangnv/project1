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

class GetNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getNotification(){

        $configuration = Configuration::apiKey(config('app.coinbase_key'), config('app.coinbase_secret'));
        $client = Client::create($configuration);
        $account = $client->getAccount("28985760-94fa-597d-b8b6-983aad9c804b");
        // dd($client->getAccounts());
        dd($client->getAccountTransactions($account));
        // dd($client->getNotifications());



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
