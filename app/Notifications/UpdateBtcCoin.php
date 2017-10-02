<?php

namespace App\Notifications;

use App\Notification;
use App\UserCoin;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UpdateBtcCoin {

    function __construct() {
        
    }
    /** 
     * @author Huynq
     * @internal Cronjob update Btc Coin Amount User
     */
    public static function UpdateBtcCoinAmount(){

        $interval = 30;
        
        for ($i = 0; $i < ceil(60/$interval); $i++) {
            //Get Notification
            $dataNotApproved = Notification::where("status",0)->get();
            //Action
            if( count($dataNotApproved) > 0 ) {
               foreach ($dataNotApproved as $key => $value) {
                    $temp = json_decode($value->data);
                    if(isset($temp->data->address)){
                        //công vào tk cho user
                        if(isset(UserCoin::where('walletAddress', $temp->data->address)
                                ->first()->btcCoinAmount)){
                            $amountAddress = UserCoin::where('walletAddress', $temp->data->address)
                                ->first()->btcCoinAmount + $temp->additional_data->amount->amount;
                            $result = UserCoin::where('walletAddress', $temp->data->address)
                                   ->update([
                                       'btcCoinAmount' => 
                                        $amountAddress
                                           ]);

                            if($result == 1) {
                                Notification::where("id",$value->id)
                                    ->update(['status' => 1]);
                            }
                        }
                    }
               }
            } 
            sleep($interval);
        }
    }
    
    

}

