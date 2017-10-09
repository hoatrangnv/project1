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

    const SO_LUONG_TY_GIA_CAN_UPDATE = 3;

    public static function updateExchangRate() {
        $interval = 30;

        for ($i = 0; $i < ceil(60 / $interval); $i++) {
            if (ExchangeRate::count() == self::SO_LUONG_TY_GIA_CAN_UPDATE) {
                $dataArrayExrateWihUpdate = self::getDataUpdate();
                foreach ($dataArrayExrateWihUpdate as $exrate) {
                    ExchangeRate::where('from_currency', $exrate['from_currency'])
                            ->where('to_currency', $exrate['to_currency'])
                            ->update($exrate);
                }
            } else {
                $dataArrayExrateWihInsert = self::getDataInsert();
                ExchangeRate::insert($dataArrayExrateWihInsert);
            }
            sleep($interval);
        }
    }

    private static function getDataUpdate($type = null) {
        $helper = new \App\Helper\Helper();
        $exchrate = new ExchangeRateAPI();

        $exchrateClpUsd = $exchrate->getCLPUSDRate();
        $exchrateBtcUsd = $exchrate->getBTCUSDRate();
        $exchrateClpBtc = $exchrate->getCLPBTCRate();

        $dataArrayExrate = [
            [
                'from_currency' => ExchangeRate::CLP,
                'exchrate' => $exchrateClpUsd,
                'to_currency' => ExchangeRate::USD
            ],
            [
                'from_currency' => ExchangeRate::BTC,
                'exchrate' => $exchrateBtcUsd,
                'to_currency' => ExchangeRate::USD
            ],
            [
                'from_currency' => ExchangeRate::CLP,
                'exchrate' => $exchrateClpBtc,
                'to_currency' => ExchangeRate::BTC
            ]
        ];

        return $dataArrayExrate;
    }
    
    private static function getDataInsert(){
        $helper = new \App\Helper\Helper();
        $exchrate = new ExchangeRateAPI();

        $exchrateClpUsd = $exchrate->getCLPUSDRate();
        $exchrateBtcUsd = $exchrate->getBTCUSDRate();
        $exchrateClpBtc = $exchrate->getCLPBTCRate();
        /* make array insert db */
        $dataArrayExrate = [
            [
                'from_currency' => ExchangeRate::CLP,
                'exchrate' => $exchrateClpUsd,
                'to_currency' => ExchangeRate::USD,
                'created_at' => $helper->getTimeNow(),
                'updated_at' => $helper->getTimeNow()
            ],
            [
                'from_currency' => ExchangeRate::BTC,
                'exchrate' => $exchrateBtcUsd,
                'to_currency' => ExchangeRate::USD,
                'created_at' => $helper->getTimeNow(),
                'updated_at' => $helper->getTimeNow()
            ],
            [
                'from_currency' => ExchangeRate::CLP,
                'exchrate' => $exchrateClpBtc,
                'to_currency' => ExchangeRate::BTC,
                'created_at' => $helper->getTimeNow(),
                'updated_at' => $helper->getTimeNow()
            ]
        ];

        return $dataArrayExrate;
    }

}
