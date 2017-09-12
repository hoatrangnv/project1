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

            //check neu da active roi redirect ve login
            try {
                $activeUser = User::where('email', '=', $data[1])->firstOrFail();
                if( $activeUser->active == 1 ) {
                    return redirect("home");
                }
            } catch (Exception $e) {
                echo "Error : ket noi";
                die();    
            }
            //kiem tra va update kich hoat tk
            if ( $data[0] = hash( "sha256", md5( md5( $data[1] ) ) ) ) {
                try {
                    $affectedRows = User::where( 'email', '=', $data[1] )->update( ['active' => 1] );
                    if($affectedRows == 1){
                        return redirect("login");
                    }else{
                        echo "Không thể active được tài khoản";
                    }
                } catch ( Exception $e ) {
                    echo "<pre>";
                    var_dump($e);                        
                }
            } else {
                echo "Thong tin sai khong the active";die();
            }
        } else {
            echo "Thong tin sai khong the active";die();
        }
    }
}

