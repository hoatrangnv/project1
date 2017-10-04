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

    public static function getCLPUSDRate()
    {
        return 1.12;
    }

    public function getBTCUSDRate() 
    {
        $url = config('app.link_ty_giaff') ?  config('app.link_ty_gia') : self::DEFAULT_BTC_EXCHANGE_URL;
        $path = rtrim($url, '/') . '/btcusd';

        $response = $this->client->request('GET', $path);

        $result =json_decode($response->getBody(), true);
        
        return $result['last'];
    }

    public function getCLPBTCRate()
    {
        return self::getCLPUSDRate() / self::getBTCUSDRate();
    }
}
