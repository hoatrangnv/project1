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
        $date = time();
        $data = file_get_contents('php://input');
        $text = print_r($data,true);

        //Insert DB
        $notification = Notification::create(
            [
                'data' => $text,
                'status' => 0
            ]
        );

    }       

}
