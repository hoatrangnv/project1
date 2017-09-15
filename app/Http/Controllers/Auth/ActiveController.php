<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use URL;
use App\Notifications\UserRegistered;

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
    public function activeAccount(Request $request, $infoActive = "" ){
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
            $count = User::where('email','=', $data[1])
                            ->where('updated_at','>', Carbon::now()->subDay(3))
                            ->count();
            if($count==0){
                $request->session()->flash('error', 'Link Active Account expired!');
            }else{
                //kiem tra va update kich hoat tk
                if ( $data[0] = hash( "sha256", md5( md5( $data[1] ) ) ) ) {
                    try {
                        $affectedRows = User::where( 'email', '=', $data[1] )->update( ['active' => 1] );
                        //Active vaf redirect ve trang thong bao kem theo link login
                        if($affectedRows == 1){
                            return redirect("notification/useractive");
                        }else{
                            $request->session()->flash('error', 'Không thể active được tài khoản!');
                        }
                    } catch ( Exception $e ) {
                        echo "<pre>";
                        var_dump($e);
                    }
                } else {
                    $request->session()->flash('error', 'Thong tin sai khong the active!');
                }
            }

        } else {
            $request->session()->flash('error', 'Thong tin sai khong the active!');
        }
        return view('adminlte::auth.reactive');
    }
    public function reactiveAccount(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'email' => 'required|email',
            ]);
            $email = $request->email;
            $count = User::where('email', '=', $email)->count();
            if ($count == 0) {
                $request->session()->flash('error', 'Email ko ton tai!');
            } else {
                $user = User::where('email', '=', $email)->first();
                $user->updated_at = date('Y-m-d H:i:s');
                $user->save();
                $encrypt = [hash("sha256", md5(md5($email))), $email];
                $linkActive = URL::to('/active') . "/" . base64_encode(json_encode($encrypt));
                $user->notify(new UserRegistered($user, $linkActive));
                $request->session()->flash('status', 'Link active dc dc gui vao mail. Vui long check mail.');
            }
        }
        return view('adminlte::auth.reactive');
    }

}

