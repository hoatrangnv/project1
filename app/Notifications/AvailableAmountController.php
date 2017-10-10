<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Notifications;
use App\UserCoin;
use DB;
use App\Wallet;
/**
 * Description of AvailableAmountController
 *
 * @author huydk
 */
class AvailableAmountController {
    
    public static function getAvailableAmount(){
        $passDate = date('Y-m-d',strtotime("-6 months"));

        $dataRelaseTimeToday = DB::table('wallets')
                ->select('userId','inOut',DB::raw('SUM(amount) as sumamount'))
                ->where('walletType',Wallet::REINVEST_WALLET) 
                ->whereDate('updated_at', $passDate) //use updated_at because of private sale issue
                ->groupBy('userId','inOut')
                ->get();

        //get all userId from all record from $dataRelaseTimeYesterday
        $availableUser = array();
        foreach ($dataRelaseTimeToday as $value) {
            if($value->inOut == Wallet::IN) 
                    $availableUser[$value->userId]  = $value->sumamount;
        }
        //update available amount
        if(isset($availableUser) && count($availableUser) > 0 ){
            foreach ($availableUser as $key => $value) {
                $availableAmount = UserCoin::where("userId",$key)->first()->availableAmount + $value;
                UserCoin::where("userId",$key)
                        ->update(["availableAmount" => $availableAmount]);
            }
        }
    }
}
