<?php
namespace App\Http\Controllers;

use App\Notification;

class GetNotificationController extends Controller
{ 

    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function getNotification(){
        dd(config('app.bitgo_hook'));
        $date = time();
        $data = file_get_contents('php://input');
        // $text = print_r($data,true);
        // $file = fopen("/var/www/html/cryptolending/public/history_notification/text_".$date.".txt", 'w');
        // fwrite($file, $text);
        //Insert DB
        try {
            $notification = Notification::create(
            [
                'data' => $data,
                'status' => 0
            ]
        );
        } catch (Exception $e) {
            
        }
    }       

}
