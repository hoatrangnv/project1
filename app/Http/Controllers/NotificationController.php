<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

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
}

