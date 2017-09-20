<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use App\Notification;
use App\UserCoin;
use Illuminate\Contracts\Logging\Log;
/**
 * Description of TestController
 *
 * @author huydk
 */
class TestController {
    //put your code here
    function test($param = null) {
        //Get Notification
        $dataNotApproved = Notification::where("status",0)->get();
        
        //Action
        if( count($dataNotApproved) > 0 ) {
           foreach ($dataNotApproved as $key => $value) {
               
                $temp = json_decode($value->data);
                
                $result = UserCoin::where('accountCoinBase', $temp->account->id)
                       ->update([
                           'btcCoinAmount' => 
                            $temp->additional_data->amount->amount
                               ]);
                if($result == 1) {
                    Notification::where("id",$value->id)
                        ->update(['status' => 1]);
                }

           }
       }
    }
    
}
