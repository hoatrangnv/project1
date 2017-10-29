<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Cronjob;

use App\Withdraw;
use App\Wallet;
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Client;

/**
 * Description of UpdateStatusBTCTransaction
 *
 * @author giangdt
 */
class UpdateStatusBTCWithdraw
{
    
    public static function updateStatusWithdraw()
    {

        $configuration = Configuration::apiKey( 
                    config('app.coinbase_key'), 
                    config('app.coinbase_secret') );
            
        $client = Client::create($configuration);

        $account = $client->getAccount(config('app.coinbase_account'));

        //List withdraw not completed
        $listWithdrawNotUpdated = Withdraw::where("status", 0)->whereNotNull('amountBTC')->get();

        foreach($listWithdrawNotUpdated as $withdraw) {
            
            $transactionDetail = $client->getAccountTransaction($account, $withdraw->transaction_id);
            if($transactionDetail->getStatus() == "completed") {
                $withdraw->status = 1;
                $withdraw->save();

                //Updat status in table wallets from "Pending" => "Completed"
                Wallet::find($withdraw->wallet_id)->update(['note' => "Completed"]);
            }
        }
    }
}
