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

    const CLP_EXCHANGE_URL = 'https://api.livecoin.net/exchange/ticker';

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getCLPUSDRate()
    {
        $clpUSDRate = self::getCLPBTCRate() * self::getBTCUSDRate();

        return round($clpUSDRate, 2);
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
        $url = self::CLP_EXCHANGE_URL;
        $path = rtrim($url, '/') . '?currencyPair=CLP/BTC';

        $response = $this->client->request('GET', $path);

        $result =json_decode($response->getBody(), true);
        
        return $result['last'];
    }
}
