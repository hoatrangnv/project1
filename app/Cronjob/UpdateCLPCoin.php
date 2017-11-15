<?php

namespace App\Cronjob;

use App\CLPNotification;
use App\CLPWallet;
use App\UserCoin;
use App\Wallet;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Client;
use App\CLPWalletAPI;
use Log;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UpdateCLPCoin {

    /** 
     * @author Huynq
     * @internal Cronjob update Btc Coin Amount User
     */
    public static function UpdateClpCoinAmount(){

        //Get Notification
        $dataNotApproved = CLPNotification::where("completed_status",0)->get();
        //Action
        if( count($dataNotApproved) > 0 ) 
        {
            $clpApi = new CLPWalletAPI();
           foreach ($dataNotApproved as $key => $notify) 
           {
                $temp = json_decode($notify->data);
                if(isset($temp->address))
                {
                        $clpWallet = CLPWallet::where('address', $temp->address)->first();

                        $userCoin = isset($clpWallet->userCoin) ? $clpWallet->userCoin : null ;

                        if(isset($userCoin->clpCoinAmount))
                        {
                            try {
                                $isExist = CLPNotification::where('transaction_hash', $temp->transactionHash)->count();
                                //Get transaction info
                                $tranStatus = $clpApi->getTransactionInfo($temp->transactionHash);

                                if ($notify->pending_status == 0 && $isExist == 0) {
                                    $fieldCLP = [
                                        'walletType' => Wallet::CLP_WALLET,
                                        'type' => Wallet::DEPOSIT_CLP_TYPE,
                                        'inOut' => Wallet::IN,
                                        'userId' => $userCoin->userId,
                                        'amount' => ($temp->amount / pow(10, 9)),
                                        'note' => 'Pending'
                                    ];

                                    $insertData = Wallet::create($fieldCLP);

                                    CLPNotification::where("id", $notify->id)->update(['transaction_hash' => $temp->transactionHash, 'pending_status' => 1, 'wallet_id' => $insertData->id]);

                                }

                                if ($notify->pending_status == 1 && $tranStatus == 'completed' ) {
                                    $userCoin->clpCoinAmount = $userCoin->clpCoinAmount + ($temp->amount / pow(10, 9));
                                    $userCoin->save();

                                    //Update wallet pending -> completed
                                    Wallet::where("id", $notify->wallet_id)->update(['note' => 'Completed']);

                                    CLPNotification::where("id", $notify->id)
                                        ->update(['completed_status' => 1]);
                                }
                            } catch (\Exception $e) {
                                Log::error('Cronjob update clp amount has error: ' . $e->getMessage());
                                Log::error('Notificaiton Id: ' . $notify->id);
                                //Log::info($e->getTraceAsString());
                            }
                        }

                }
           }
        } 
    }
    
    

}

