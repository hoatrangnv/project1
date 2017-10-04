<?php

namespace App;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

/**
*  @author GiangDT
*/
class CLPWalletAPI
{

    const DEFAULT_API_URL = 'http://99.193.6.228:3080';

    private $apiUrl;

    private $client;


    public function __construct(array $attributes = [])
    {
        $this->apiUrl = self::DEFAULT_API_URL;
        $this->client = new Client();
    }

    public function generateWallet() 
    {
        $path = $this->apiUrl . '/generate-wallet';
        $result = $this->client->request('GET', $path);

        $result = json_decode($result);
        
        return $result
    }
}
