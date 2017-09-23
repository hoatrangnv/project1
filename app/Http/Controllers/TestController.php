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
use App\User;

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
    
}
