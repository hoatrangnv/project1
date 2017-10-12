<?php

namespace App;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

/**
*  @author GiangDT
*/
class ExchangeRateAPI
{

    const DEFAULT_BTC_EXCHANGE_URL = 'https://www.bitstamp.net/api/v2/ticker/';


    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getCLPUSDRate()
    {
        $clpPrice = config('app.clp_price');
        $currentDate = date('Y-m-d');

        $privateSaleStart = date('Y-m-d', strtotime(config('app.first_private_start')));
        $privateSaleEnd = date('Y-m-d', strtotime(config('app.first_private_end')));

        $secondSaleStart = date('Y-m-d', strtotime(config('app.second_private_start')));
        $secondSaleEnd = date('Y-m-d', strtotime(config('app.second_private_end')));

        $preSaleStart = date('Y-m-d', strtotime(config('app.pre_sale_start')));
        $preSaleEnd = date('Y-m-d', strtotime(config('app.pre_sale_end')));

        if($privateSaleStart <= $currentDate && $currentDate <= $privateSaleEnd)
        {
            $clpPrice = config('app.first_price');
        }

        //Private sale 2
        if($secondSaleStart <= $currentDate && $currentDate <= $secondSaleEnd)
        {
            $clpPrice = config('app.second_price');
        }

        //Pre sale
        if($preSaleStart <= $currentDate && $currentDate <= $preSaleEnd)
        {
            $clpPrice = config('app.pre_price');
        }
        
        return $clpPrice;
    }

    public function getBTCUSDRate() 
    {
        $url = config('app.link_ty_gia') ?  config('app.link_ty_gia') : self::DEFAULT_BTC_EXCHANGE_URL;
        $path = rtrim($url, '/') . '/btcusd';

        $response = $this->client->request('GET', $path);

        $result =json_decode($response->getBody(), true);
        
        return $result['last'];
    }

    public function getCLPBTCRate()
    {
        $clpBTCRate = self::getCLPUSDRate() / self::getBTCUSDRate();
        return round($clpBTCRate, 8);
    }
}
