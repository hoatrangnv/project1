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
use Log;

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
        $dataNotApproved = Notification::where("completed_status",0)->get();
        //Action
        if( count($dataNotApproved) > 0 ) 
        {
           foreach ($dataNotApproved as $key => $notify) 
           {
                $temp = json_decode($notify->data);
                if(isset($temp->data->address) && $temp->type == 'wallet:addresses:new-payment')
                {
                    $transaction_id = isset($temp->additional_data->transaction->id) ? $temp->additional_data->transaction->id : null;
                    if($transaction_id)
                    {
                        $userCoin = UserCoin::where('walletAddress', $temp->data->address)->first();
                        if(isset($userCoin->btcCoinAmount))
                        {
                            //Get transaction of this deposit
                            try {
                                $transactionDetail = $client->getAccountTransaction($account, $transaction_id);
                                $rawData = $transactionDetail->getRawData();
                                $status = isset($rawData['network']['status']) ? $rawData['network']['status'] : '';

                                $isExist = Notification::where('transaction_id', $transaction_id)->where('name', $temp->data->name)->count();
                                if( ($status == 'confirmed' || $transactionDetail->getStatus() == "completed") 
                                    && $notify->pending_status == 0 
                                    && $isExist == 0 )
                                {
                                    $fieldBTC = [
                                        'walletType' => Wallet::BTC_WALLET,
                                        'type' => Wallet::DEPOSIT_BTC_TYPE,
                                        'inOut' => Wallet::IN,
                                        'userId' => $userCoin->userId,
                                        'amount' => $temp->additional_data->amount->amount,
                                        'note' => 'Pending' 
                                    ];

                                    $insertData = Wallet::create($fieldBTC);

                                    Notification::where("id", $notify->id)->update(['pending_status' => 1, 'transaction_id' => $transaction_id, 'name' => $temp->data->name,'wallet_id' => $insertData->id]);
                                }

                                if($notify->pending_status == 1 && $transactionDetail->getStatus() == "completed") 
                                {
                                    $wallet = Wallet::where("id", $notify->wallet_id)->first();

                                    $amountAddress = $userCoin->btcCoinAmount + $wallet->amount;
                                    $userCoin->btcCoinAmount = $amountAddress;
                                    $result = $userCoin->save();

                                    //Update wallet pending -> completed
                                    $wallet->note = "Completed";
                                    $wallet->save();

                                    Notification::where("id",$notify->id)
                                        ->update(['completed_status' => 1]);
                                }
                            } catch (\Exception $e) {
                                Log::error('Cronjob update btc amount has error: ' . $e->getMessage());
                                Log::error('Notificaiton Id: ' . $notify->id);
                                //Log::info($e->getTraceAsString());
                            }
                        }
                    }
                }
           }
        } 
    }
    
    

}

