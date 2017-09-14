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
        return view('adminlte::notification.notiactive');
    }
}

