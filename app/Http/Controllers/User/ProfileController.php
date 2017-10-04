<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\User;
use Auth;
use Session;
use Hash;
use Google2FA;
use App\Http\Controllers\Controller;
use Validator;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Profile
 */
class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        parent::__construct();
    }

    /**
     * Show profile user.
     *
     * @return Response
     */
    public function index()
    {
        $lstCountry = config('cryptolanding.lstCountry');
        $lstCountry = array_merge(array("0" => 'Choose a country'), $lstCountry);
        $sponsor = User::where('id', Auth::user()->refererId)->first();
        $google2faUrl = Google2FA::getQRCodeGoogleUrl(
            config('app.name'),
            Auth::user()->email,
            Auth::user()->google2fa_secret
        );
        return view('adminlte::profile.index', compact('lstCountry', 'sponsor', 'google2faUrl'));
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($user){
            $user->fill($request->except('password'));
            $user->save();
            flash()->success('Profile has been updated.');
            return redirect()->route('profile.index');
        }else{
            return redirect()->route('profile.index')
                ->with('error',
                    'Profile not update!');
        }
    }
    /**
     * Change password profile user.
     *
     * @return Response
     */
    public function changePassword(Request $request){
        
        $a = $this->validate($request, [
            'new_password'=>'required|min:6'
        ]);

        if ( Hash::check($request->old_password, Auth::user()->password ) ) {
            try {
                User::where('id',Auth::user()->id)
                    ->update( [ 'password' => bcrypt( $request->new_password ) ] );
                return Response::json([
                    "success" => true,
                    "result"  => null
                ] );
            } catch (Exception $e) {
                return Response::json([
                    "success" => false
                ]);
            }
        }else{
            return Response::json([
                "errorcode" => 1
            ]);
        }

    }

    /**
     * Author:huynq
     * Switch on off two-factor authentication
     * @return boolean
     */
    public function switchTwoFactorAuthen(Request $request){
        try {
            $is2fa = Auth::user()->is2fa;
            if($request->status == 1){//off 2fa
                if($request->codeOtp != ''){
                    $key = Auth::user()->google2fa_secret;
                    $valid = Google2FA::verifyKey($key, $request->codeOtp);
                    if($valid){
                        if($is2fa == 0){
                            return Response::json([
                                "success" => false,
                                "msg"  => "2Fa is off"
                            ]);
                        }else{
                            User::where('id',Auth::user()->id) ->update( [ 'is2fa' => 0, 'google2fa_secret' => Google2FA::generateSecretKey(16) ] );
                            return Response::json([
                                "success" => true,
                                "msg"  => null
                            ]);
                        }
                    }else{
                        return Response::json([
                            "success" => false,
                            "msg"  => "code OTP no  match"
                        ]);
                    }
                }else{
                    return Response::json([
                        "success" => false,
                        "msg"  => "Error codeOtp inv"
                    ]);
                }
            }else{//on 2fa
                if($request->codeOtp != '') {
                    $key = Auth::user()->google2fa_secret;
                    $valid = Google2FA::verifyKey($key, $request->codeOtp);
                    if($valid){
                        if ($is2fa == 1) {
                            return Response::json([
                                "success" => false,
                                "msg" => "2Fa is on"
                            ]);
                        } else {
                            User::where('id', Auth::user()->id)->update(['is2fa' => 1]);
                            return Response::json([
                                "success" => true,
                                "msg" => null
                            ]);
                        }
                    }else{
                        return Response::json([
                            "success" => false,
                            "msg"  => "code OTP no  match"
                        ]);
                    }
                }else{
                    return Response::json([
                        "success" => false,
                        "msg"  => "Error codeOtp inv"
                    ]);
                }
            }
        } catch (Exception $e) {
            throw $e->gettraceasstring();
        }
    }


    /*
    *Author huynq
    *Danh hieu F1
    */
    private function appellationF1($value=''){

    }

    /*
    *Author huynq
    *Danh hieu F1
    */
    private function tichLuy($value=''){

    }
    private function getGoogleUrl($key){
        return Google2FA::getQRCodeGoogleUrl(
            $this->name,
            $this->email,
            $key
        );
    }
    public function upload(Request $request){
        $validator = Validator::make($request->all(),
            [
                'file' => 'image',
            ],
            [
                'file.image' => 'The file must be an image (jpeg, png, bmp, gif, or svg)'
            ]);
        if ($validator->fails())
            return array(
                'err' => true,
                'msg' => $validator->getMessageBag()->toArray()['file'][0]
            );
        $extension = $request->file('file')->getClientOriginalExtension(); // getting image extension
        $folder ='/uploads/images/';
        $dir = public_path($folder);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $request->file('file')->move($dir, $filename);
        $user = Auth::user();
        $user->approve = 0;
        $photo_verification = json_decode($user->photo_verification);
        if($photo_verification){
            if($request->type == 'scan_photo'){
                $photo_verification['scan_photo'] = $folder.$filename;
            }elseif($request->type == 'holding_photo'){
                $photo_verification['holding_photo'] = $folder.$filename;
            }
        }else{
            if($request->type == 'scan_photo'){
                $photo_verification['scan_photo'] = $folder.$filename;
            }elseif($request->type == 'holding_photo'){
                $photo_verification['holding_photo'] = $folder.$filename;
            }
        }
        $user->photo_verification = json_encode($photo_verification);
        $user->save();
        return array(
            'err' => false,
            'image' => $folder.$filename
        );
    }
}