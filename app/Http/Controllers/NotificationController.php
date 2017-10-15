<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Auth;
/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
class NotificationController extends Controller
{
    /*
    author huynq
    active Acc with email
    */
    public function userActive(){
        return view('adminlte::notification.active');
    }

    public function userActived(){
        return view('adminlte::notification.actived');
    }
    
    public function userNotiActive() {
        if(Auth::user()){
            redirect('home');
        }

        $currentDate = date('Y-m-d');
        $secondSaleEnd = date('Y-m-d', strtotime(config('app.second_private_end')));
        
        $private_sale_end = 0;
        if($currentDate > $secondSaleEnd) {
            $private_sale_end = 1;
        }
        return view('adminlte::notification.notiactive', array('private_sale_end' => $private_sale_end));
    }
}

