<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\UserData;
use App\BonusBinary;
use App\Package;
use Auth;
use Session;
use Mail;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class SendmailController extends Controller
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

    public function sendMail(){
        
        $dataSendMail = [
            'mail_to' => '?@gmail.com',
            'name'    => '?'
        ];

        try {
            if(count($dataSendMail)>0){
                $result = Mail::send('templates.mail.register', $dataSendMail, function($message) use ($dataSendMail) 
                {
                    $message->to( $dataSendMail['mail_to'], $dataSendMail['name'] )->subject('Welcome to the crypyto!');
                });
                return $result;
            } 
        } catch (Exception $e) {
            var_dump($e->getmessage());
        }
    }

}