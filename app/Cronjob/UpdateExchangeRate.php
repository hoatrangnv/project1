<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Cronjob;
use App\ExchangeRate;
use App\ExchangeRateAPI;
/**
 * Description of UpdateExchangeRate
 *
 * @author huydk
 */
class UpdateExchangeRate {
    
    public static function updateExchangRate(){
        
        $interval = 30;
        
        for ($i = 0; $i < ceil(60/$interval); $i++) {
            $exchrate =  new ExchangeRateAPI();
        
            $exchrateClpUsd = $exchrate->getCLPUSDRate();
            $exchrateBtcUsd = $exchrate->getBTCUSDRate();
            $exchrateClpBtc = $exchrate->getCLPBTCRate();
            /* make array insert db*/
            $dataArrayExrate = [
                [
                    'from_currency' => ExchangeRate::CLP,
                    'exchrate'      => $exchrateClpUsd,
                    'to_currency'   => ExchangeRate::USD,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'from_currency' => ExchangeRate::BTC,
                    'exchrate'      => $exchrateBtcUsd,
                    'to_currency'   => ExchangeRate::USD,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ],
                [
                    'from_currency' => ExchangeRate::CLP,
                    'exchrate'      => $exchrateClpBtc,
                    'to_currency'   => ExchangeRate::BTC,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ]
            ];
            
            ExchangeRate::insert($dataArrayExrate);

            sleep($interval);
        }
    }
}
