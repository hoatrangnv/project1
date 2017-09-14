<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;

use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;
use URL;
use Auth;

/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
class TestController extends Controller
{
    /*
    author huynq
    active Acc with email
    */
    public function test() {
        $name = "huydk2";
        
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
        
        dd($data);
        
    }
}

