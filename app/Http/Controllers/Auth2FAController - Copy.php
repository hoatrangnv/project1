<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Session;
use Storage;
use Google2FA;

class Auth2FAController extends Controller
{
    private $fileName = 'google2fasecret.key';
    private $name = 'PragmaRX';
    private $email = 'google2fa@pragmarx.com';
    private $secretKey;
    private $keySize = 25;
    private $keyPrefix = '';
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
    }
    public function index(){
        $valid = $this->validateInput($key = $this->getSecretKey());
        $googleUrl = $this->getGoogleUrl($key);
        $inlineUrl = $this->getInlineUrl($key);
        return view('adminlte::auth.authenticator')->with(compact('key', 'googleUrl', 'inlineUrl', 'valid'));
        //return view('adminlte::auth.authenticator');
    }
    public function show(){
        return view('adminlte::auth.authenticator');
    }
    public function check2fa(){
        $isValid = $this->validateInput();
        // Render index and show the result
        return $this->index($isValid);
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
            $key = Google2FA::generateSecretKey($this->keySize, $this->keyPrefix);
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
