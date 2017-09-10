<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
class ActiveController extends Controller
{
    /*
    author huynq
    active Acc with email
    */
    public function activeAccount( $infoActive = "" ){
        if ( strlen( $infoActive ) > 0 ){
            $data = json_decode( base64_decode( $infoActive ) );
            if ( $data[0] = hash("sha256", md5(md5($data[1]))) {

            } else {

            }
        } else {

        }
    }
}
