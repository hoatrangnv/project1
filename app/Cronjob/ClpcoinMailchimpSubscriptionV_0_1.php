<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/16/2017
 * Time: 10:48 PM
 */

namespace App\Cronjob;
use App\User;
use GuzzleHttp\Client;
use Log;

class ClpcoinMailchimpSubscriptionV_0_1
{
    CONST API_KEY = '9dc2b4cb8e5e61be15c9a480ce1c7f27-us17';
    CONST LIST_ID = '991dbb6910';

    public static function cronjobUpdate(){
        set_time_limit(0);

        $users = User::whereNull('mailchimp')->get();
        $client = new Client();

        foreach ($users as $user)
        {
            $json = json_encode([
                'email_address' => $user->email,
                'status'        => 'subscribed',
                'merge_fields'  => [
                    'FNAME'     => $user->firstname,
                    'LNAME'     => $user->lastname
                ]
            ]);

            $memberID = md5(strtolower($user->email));
            $dataCenter = substr(self::API_KEY,strpos(self::API_KEY,'-')+1);
            $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . self::LIST_ID . '/members/' . $memberID;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_USERPWD, 'user:' . self::API_KEY);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // store the status message based on response code
            if ($httpCode == 200) {
                $user->mailchimp = 1;
                $user->save();
                echo " is subscribed\r\n";
            } else {
                switch ($httpCode) {
                    case 214:
                        $user->mailchimp = 1;
                        $user->save();
                        Log::info("user already subscribed.\r\n");
                        break;
                    default:
                        $user->mailchimp = 0;
                        $user->save();
                        Log::info("is not subscribed. Some problem occurred, please try again.\r\n");
                        break;
                }
            }
        }
    }
}