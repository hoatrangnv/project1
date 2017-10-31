<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Notification;
use App\UserCoin;
use App\User;
use App\Wallet;
use DB;
use Log;
use App\ExchangeRate;
use App\ExchangeRateAPI;
use App\Cronjob\AutoAddBinary;
use App\CLPWallet;
use App\CLPWalletAPI;
use App\Helper\Helper;
use App\Cronjob\GetClpWallet;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Account;
use Coinbase\Wallet\Resource\Address;
use App\Cronjob\Bonus;
use App\Cronjob\AutoBuyPack;

/**
 * Description of TestController
 *
 * @author giangdt
 */
class TestController {
     private $helper;
    private $clpwallet;
    private $clpwalletapi;

    function __construct(Helper $helper, CLPWallet $clpwallet, CLPWalletAPI $clpwalletapi) {
        $this->helper = $helper;
        $this->clpwallet = $clpwallet;
        $this->clpwalletapi = $clpwalletapi;
    }
    //put your code here
    function testInterest($param = null) {
        //Get Notification
        User::bonusDayCron();
        echo "Return bonus day for user successfully!";
    }

    function testBinary($param = null) {
        //Get Notification
        User::bonusBinaryWeekCron();
        echo "Return binary bonus this week for user successfully!";
    }

    function testAutoAddBinary($param = null) {
        //Get Notification
        AutoAddBinary::addBinary();
        echo "Return auto add binary successfully!";
    }

    function getAvailableAmount() {

        try {

            $passDate = date('Y-m-d', strtotime("-6 months"));

            $dataRelaseTimeToday = DB::table('wallets')
                    ->select('userId', 'inOut', DB::raw('SUM(amount) as sumamount'))
                    ->whereDate('created_at', $passDate)
                    ->groupBy('userId', 'inOut')
                    ->get();

            //get all userId from all record from $dataRelaseTimeYesterday
            $availableUser = array();
            foreach ($dataRelaseTimeToday as $value) {
                if ($value->inOut == 'in')
                    $availableUser[$value->userId] = $value->sumamount;
            }
            //update available amount
            if (isset($availableUser) && count($availableUser) > 0) {
                foreach ($availableUser as $key => $value) {
                    UserCoin::where("userId", $key)
                            ->update(
                                    ["availableAmount" =>
                                        ( UserCoin::where("userId", $key)->first()->
                                        availableAmount + $value )
                                    ]
                    );
                }
            }
        } catch (\Exception $ex) {
            Log::error($ex->gettraceasstring());
        }
    }

    function test() {
        set_time_limit(0);

        AutoBuyPack::AutoBuyPack();
        exit("XXXXX");
        $configuration = Configuration::apiKey( config('app.coinbase_key'), config('app.coinbase_secret'));
        $client = Client::create($configuration);

        //Account detail
        $account = $client->getAccount(config('app.coinbase_account'));

        //Get all user in userCoin
        $listUser = UserCoin::where('userId', '>', 2)->orderBy('userId', 'asc')->get();
        foreach($listUser as $user)
        {
            try {
                $address = $client->getAccountAddress($account, $user->accountCoinBase);
                //$address = $client->getAccountAddress($account, 'cb0b3e16-3aca-5561-bfce-2e231925e484');
                //$address = $client->getAccountAddress($account, 'b5cac226-7cc9-5ddf-8df5-6dac0b7ba3ae');
                if($address instanceof Address ) continue;
            } catch(\Exception $e) {
                // Generate new address and get this adress
                $name = $user->user->name;
                if(empty($name)) continue;
                
                $address = new Address([
                    'name' => $name
                ]);

                //Generate new address
                $client->createAccountAddress($account, $address);

                //Get all address
                $listAddresses = $client->getAccountAddresses($account);

                $address = '';
                $id = '';
                foreach($listAddresses as $add) {
                    if($add->getName() == $name) {
                        $address = $add->getAddress();
                        $id = $add->getId();
                        break;
                    }
                }

                $user->walletAddress = $address;
                $user->accountCoinBase = $id;
                $user->save();
            }
        }

        dd("successfully");
    }

}
