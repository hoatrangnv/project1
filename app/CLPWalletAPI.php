<?php

namespace App;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

/**
*  @author GiangDT
*/
class CLPWalletAPI
{

    const DEFAULT_API_URL = 'http://199.193.6.228:3080/api';

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

        //SUCCESS: $result = { success : 1, tx : resETH.transactionHash, gasUsed : gasEstimate, address : resETH.address }
        //FAIL : { success : 0, err : ex.message }
        $result = json_decode($result);
        
        return $result;
    }

    public function addInvestor($address, $amount) 
    {
        $path = $this->apiUrl . '/add-investor/' . $address . '/' . $amount;
        $result = $this->client->request('GET', $path);

        //SUCCESS: responseResult = { success : 1, tx : result.tx, gasUsed : result.receipt.gasUsed };
        //FAIL : responseResult = { success : 0, err : err };
        $result = json_decode($result);
        
        return $result;
    }

    public function withdrawCLPFromUserWallet() 
    {
        $path = $this->apiUrl . '/generate-wallet';
        $result = $this->client->request('GET', $path);

        //SUCCESS: $result = { success : 1, tx : resETH.transactionHash, gasUsed : gasEstimate, address : resETH.address }
        //FAIL : { success : 0, err : ex.message }
        $result = json_decode($result);
        
        return $result;
    }
}
