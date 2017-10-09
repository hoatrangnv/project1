<?php

namespace App\Notifications;

use App\Notification;
use App\UserCoin;
use App\Wallet;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Client;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UpdateBtcCoin {

    /** 
     * @author Huynq
     * @internal Cronjob update Btc Coin Amount User
     */
    public static function UpdateBtcCoinAmount(){

        $configuration = Configuration::apiKey( 
                    config('app.coinbase_key'), 
                    config('app.coinbase_secret') );
            
        $client = Client::create($configuration);

        $account = $client->getAccount(config('app.coinbase_account'));
        
        //Get Notification
        $dataNotApproved = Notification::where("status",0)->get();
        //Action
        if( count($dataNotApproved) > 0 ) 
        {
           foreach ($dataNotApproved as $key => $value) 
           {
                $temp = json_decode($value->data);
                if(isset($temp->data->address))
                {
                    //công vào tk cho user
                    $userCoin = UserCoin::where('walletAddress', $temp->data->address)->first();
                    if(isset($userCoin->btcCoinAmount))
                    {
                        //Get transaction of this deposit
                        $transactionDetail = $client->getAccountTransaction($account, $temp->additional_data->transaction->id);
                        if($transactionDetail->status == "completed") 
                        {
                            $amountAddress = $userCoin->btcCoinAmount + $temp->additional_data->amount->amount;
                            $userCoin->btcCoinAmount = $amountAddress;
                            $result = $userCoin->save();

                            $fieldBTC = [
                                'walletType' => Wallet::BTC_WALLET,
                                'type' => Wallet::DEPOSIT_BTC_TYPE,
                                'inOut' => Wallet::IN,
                                'userId' => $userData->userId,
                                'amount' => $temp->additional_data->amount->amount
                            ];
                            Wallet::create($fieldBTC);
                            
                            Notification::where("id",$value->id)
                                ->update(['status' => 1]);
                        }
                    }
                }
           }
        } 
    }
    
    

}

