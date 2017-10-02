<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use App\Notification;
use App\UserCoin;

use App\User;
use App\Wallet;
use DB;
use Log;

/**
 * Description of TestController
 *
 * @author giangdt
 */
class TestController {
    //put your code here
    function testInterest($param = null) {
        //Get Notification
        User::bonusDayCron();
        echo "Return bonus day for user successfully!";
    }

    function testBinary($param = null) {
        //Get Notification
        User::bonusBinaryWeekCron();
        echo "Return binary bonus this week for user successfully!";
    }
    
    function getAvailableAmount() {
       
        try {
            
            $passDate = date('Y-m-d',strtotime("-6 months"));
            
            $dataRelaseTimeToday = DB::table('wallets')
                    ->select('userId','inOut',DB::raw('SUM(amount) as sumamount'))
                    ->whereDate('created_at', $passDate)
                    ->groupBy('userId','inOut')
                    ->get();
            
            //get all userId from all record from $dataRelaseTimeYesterday
            $availableUser = array();
            foreach ($dataRelaseTimeToday as $value) {
                if($value->inOut == 'in') 
                        $availableUser[$value->userId]  = $value->sumamount;
            }
            //update available amount
            if(isset($availableUser) && count($availableUser) > 0 ){
                foreach ($availableUser as $key => $value) {
                    UserCoin::where("userId",$key)
                            ->update(
                            ["availableAmount" => 
                                ( UserCoin::where("userId",$key)->first()->
                            availableAmount + $value )
                            ]        
                            );
                }
            }
        } catch (\Exception $ex) {
            Log::error( $ex->gettraceasstring() );
        }
       
    }
 
}
