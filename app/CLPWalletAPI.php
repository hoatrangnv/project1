<?php

namespace App;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

/**
*  @author GiangDT
*/
class CLPWalletAPI
{

    const DEFAULT_API_URL = 'http://199.193.6.228:3082/api';

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
        $response = $this->client->request('GET', $path);

        //SUCCESS: $result = { success : 1, tx : resETH.transactionHash, gasUsed : gasEstimate, address : resETH.address }
        //FAIL : { success : 0, err : ex.message }

        $contents = $response->getBody()->getContents();
        $result = json_decode($contents, true);

        return $result['responseResult'];
    }

    /*public function addInvestor($address, $amount)
    {
        
        $response = $this->client->request('GET', $path);

        //SUCCESS: responseResult = { success : 1, tx : result.tx, gasUsed : result.receipt.gasUsed };
        //FAIL : responseResult = { success : 0, err : err };
        $contents = $response->getBody()->getContents();
        $result = json_decode($contents, true);

        return $result['responseResult'];
    }*/

    public function transferCLP($address, $amount)
    {
        $path = $this->apiUrl . '/transfer/' . $address . '/' . $amount;
        $response = $this->client->request('GET', $path);

        //SUCCESS: responseResult = { success : 1, tx : result.tx, gasUsed : result.receipt.gasUsed };
        //FAIL : responseResult = { success : 0, err : err };
        $contents = $response->getBody()->getContents();
        $result = json_decode($contents, true);

        return $result['responseResult'];
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

    public function getTransactionInfo($transactionHash)
    {
        $path = $this->apiUrl . '/get-transaction/' . $transactionHash;
        $response = $this->client->request('GET', $path);
        $contents = $response->getBody()->getContents();
        
        $result = json_decode($contents, true);
        
        if($result['responseResult']['tx_status'] == 'error') throw new \Exception($result['responseResult']['err']);
        
        return $result['responseResult']['tx_status'];
    }
}
