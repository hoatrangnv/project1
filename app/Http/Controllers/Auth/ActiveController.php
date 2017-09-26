<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use URL;
use App\Notifications\UserRegistered;
use App\UserData;

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
                if ( $data[0] == hash( "sha256", md5( md5( $data[1] ) ) ) ) {
                    try {
                        $user = User::where( 'email', '=', $data[1] )->first();
                        $user->active = 1;
                        $user->save();
                        UserData::find($user->id )->update( ['active' => 1] );
                        //Active vaf redirect ve trang thong bao kem theo link login
                        if($user){
                            return redirect("notification/useractive");
                        }else{
                            $request->session()->flash('error', 'Cannot activate !');
                        }
                    } catch ( Exception $e ) {
                        
                    }
                } else {
                    $request->session()->flash('error', 'Something wrongs. We cannot activated!');
                }
            }

        } else {
            $request->session()->flash('error', 'Something wrongs. We cannot activated!');
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
                UserData::find($user->id )->update( ['active' => 1] );
                $encrypt = [hash("sha256", md5(md5($email))), $email];
                $linkActive = URL::to('/active') . "/" . base64_encode(json_encode($encrypt));
                $user->notify(new UserRegistered($user, $linkActive));
                $request->session()->flash('status', 'We have sent you an email to activate account. Please check your email!');
            }
        }
        return view('adminlte::auth.reactive');
    }

}

