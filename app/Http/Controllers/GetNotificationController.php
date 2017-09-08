<?php
namespace App\Http\Controllers;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use App\BitGo\BitGoSDK;
use URL;

class GetNotificationController extends Controller
{ 

    // const TOKEN = "v2xe40828a04fbdd989d4b45e7e997821854388f44e4ae918663e057087384cd44b";

    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function getNotification(){
        dd(URL::to('/'));
        $bitgo = new BitGoSDK();
        $bitgo->authenticateWithAccessToken("v2xe40828a04fbdd989d4b45e7e997821854388f44e4ae918663e057087384cd44b");
        // $wallet = $bitgo->wallets();
        // $bitgo->unlock('0000000');
        $wallet = $bitgo->wallets()->getWallet('2NBEtswNfQ8APtc2S39R3i4FhCZoxW82D4u');
        // dd($wallet);
        // $createWallet = $wallet->createWallet("test_27222h","longpass");
        // $sendCoins = $wallet->sendCoins("2N2aY8SbfdfaHYmXqTCHEBnMvnGLLDA5age", 1000000, "huydkzhi@300393", $message = null);

        // $createWebhook = $wallet->createWebhook("transaction","http://backoffice.cryptolending.org/hook2.php");
        // dd($createWebhook);
        // $listWebhook = $wallet->listWebhooks();
        // dd($listWebhook);
        dd($createWallet,$createWallet['wallet']->getRawWallet(),$createWallet['wallet']->getID());
       //  echo "<pre>";
       // print_r();die();
    }

}
