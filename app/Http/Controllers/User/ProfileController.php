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
    const PHOTO_APPROVE_NONE = 0;
    const PHOTO_APPROVE_PENDING = 1;
    const PHOTO_APPROVE_OK = 2;
    const PHOTO_APPROVE_CANCEL = 3;

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
        //$lstCountry = config('cryptolanding.lstCountry');
        //$lstCountry = array_merge(array("0" => 'Choose a country'), $lstCountry);
        $sponsor = User::where('id', Auth::user()->refererId)->first();
        $google2faUrl = Google2FA::getQRCodeGoogleUrl(
            config('app.name'),
            Auth::user()->email,
            Auth::user()->google2fa_secret
        );
        return view('adminlte::profile.index', compact('sponsor', 'google2faUrl'));
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $time = strtotime($request->birdthday);
        $request->birdthday = date('Y-m-d',$time);

        if($user){
            $user->fill($request->except('password'));
            $user->save();
            flash()->success('Profile has been updated.');
            return redirect()->route('profile.index');
        }else{
            return redirect()->route('profile.index')
                ->with('error',
                    'Profile cannot update!');
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
                                "msg"  => "2FA is off"
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
                            "msg"  => "2FA code not match"
                        ]);
                    }
                }else{
                    return Response::json([
                        "success" => false,
                        "msg"  => "Error 2FA code"
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
                                "msg" => "2FA is on"
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
                            "msg"  => "2FA code not  match"
                        ]);
                    }
                }else{
                    return Response::json([
                        "success" => false,
                        "msg"  => "Error 2FA code"
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
        $user->approve = self::PHOTO_APPROVE_PENDING;
        $photo_verification = $user->photo_verification ? json_decode($user->photo_verification, true) : [];
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