<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Auth;

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
        //chay sang trng hom neu da login
        if(Auth::user()){
            return redirect("home");
        }

        if ( strlen( $infoActive ) > 0 ){
            $data = json_decode( base64_decode( $infoActive ) );

            //check neu da active roi va chua login hien thong bao da active kem link login
            try {
                $activeUser = User::where('email', '=', $data[1])->firstOrFail();
                if( $activeUser->active == 1 ) {
                    //chay sang trang thong bao
                    return redirect("notification/useractived");
                }
            } catch (Exception $e) {
                echo "Error : ket noi";
                die();    
            }
            //kiem tra va update kich hoat tk
            if ( $data[0] = hash( "sha256", md5( md5( $data[1] ) ) ) ) {
                try {
                    $affectedRows = User::where( 'email', '=', $data[1] )->update( ['active' => 1] );
                    //Active vaf redirect ve trang thong bao kem theo link login
                    if($affectedRows == 1){
                        return redirect("notification/useractive");
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

