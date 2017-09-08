<?php
namespace App\Http\Controllers;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use App\BitGo\BitGoSDK;

class GetNotificationController extends Controller
{ 

    // const TOKEN = "v2xe40828a04fbdd989d4b45e7e997821854388f44e4ae918663e057087384cd44b";

    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function getNotification(){
        $bitgo = new BitGoSDK();
        $bitgo->authenticateWithAccessToken("v2xe40828a04fbdd989d4b45e7e997821854388f44e4ae918663e057087384cd44b");
        // $wallet = $bitgo->wallets();
        $bitgo->unlock('0000000');
        $wallet = $bitgo->wallets()->getWallet('2N9XUSpu2Y4MRAoRELLUwtFhLJkmDfuDKfg');
        // $createWallet = $wallet->createWallet("test_10h","longpass");
        $sendCoins = $wallet->sendCoins("2N2aY8SbfdfaHYmXqTCHEBnMvnGLLDA5age", 1000000, "huydkzhi@300393", $message = null);

        $createWebhook = $wallet->createWebhook("","");


        dd($sendCoins);
    }

}
