<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Session;
use Storage;
use Google2FA;
use App\Http\Controllers\Controller;

class Auth2FAController extends Controller
{
    private $fileName = 'google2fasecret.key';
    private $name = 'PragmaRX';
    private $email = 'namhong1983@gmail.com';
    private $secretKey;
    private $keySize = 16;
    private $keyPrefix = '';
    public function __construct()
    {
    }


    public function index(Request $request){
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->keyPrefix = Auth::user()->id;
        //echo $key = $this->getSecretKey();
        $key = Auth::user()->google2fa_secret;
        echo $code = $request->get('code');
        if (!$code){
            $valid = false;
            Session::put('google2fa', false);
        }else{
            $valid = Google2FA::verifyKey($key, $code);
            if($valid){
                Session::put('google2fa', true);
                return redirect('/home');
            }
        }
        $googleUrl = $this->getGoogleUrl($key);
        $inlineUrl = $this->getInlineUrl($key);
        //return view('adminlte::auth.google2fa')->with(compact('key', 'googleUrl', 'inlineUrl', 'valid'));
        return view('adminlte::auth.authenticator')->with(compact('key', 'googleUrl', 'inlineUrl', 'valid'));
    }
    public function check2fa(){
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $key = Auth::user()->google2fa_secret;
        $code = request()->get('one_time_password');
        if (!$code){
            $valid = false;
        }else{
            $valid = Google2FA::verifyKey($key, $code);
            if($valid){
                return redirect('/home');
            }
        }
        return view('adminlte::auth.google2fa')->with(compact('valid'));
    }
    private function getGoogleUrl($key){
        return Google2FA::getQRCodeGoogleUrl(
            $this->name,
            $this->email,
            $key
        );
    }

    private function getInlineUrl($key){
        return Google2FA::getQRCodeInline(
            $this->name,
            $this->email,
            $key
        );
    }
    private function getSecretKey(){
        if (! $key = $this->getStoredKey()){
            $key = Google2FA::generateSecretKey($keySize,$keyPrefix);
            $this->storeKey($key);
        }
        return $key;
    }
    private function getStoredKey(){
        // No need to read it from disk it again if we already have it
        if ($this->secretKey){
            return $this->secretKey;
        }
        if (! Storage::exists($this->fileName)){
            return null;
        }
        return Storage::get($this->fileName);
    }
    private function storeKey($key){
        Storage::put($this->fileName, $key);
    }

    private function validateInput($key){
        // Get the code from input
        if (! $code = request()->get('code')){
            return false;
        }
        // Verify the code
        return Google2FA::verifyKey($key, $code);
    }
}