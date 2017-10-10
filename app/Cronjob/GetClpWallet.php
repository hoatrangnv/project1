<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Cronjob;

use App\CLPWallet;
use App\CLPWalletAPI;
use App\Helper\Helper;

/**
 * Description of GetClpWallet
 *
 * @author huydk
 */
class GetClpWallet {

    private $helper;
    private $clpwallet;
    private $clpwalletapi;

    function __construct() {
        $this->helper = new Helper();
        $this->clpwallet = new CLPWallet();
        $this->clpwalletapi = new CLPWalletAPI();
    }

    function getClpWallet() {
        $amountWalletAdd = config("app.amount_add_wallet");
        //TH1
        $dataWithNotNullUserId = $this->clpwallet->getDataToGetClpWalletOne($checkNullUserId = false);
        if (( $count = \count($dataWithNotNullUserId) ) > 0) {
            $insertAndUpdateCLpWallet = $this->insertAndUpdateCLpWallet($count, $amountWalletAdd, $dataWithNotNullUserId);
        }
        //TH2
        $dataWithNullUserId = $this->clpwallet->getDataToGetClpWalletOne($checkNullUserId = true);
        if (( $count = \count($dataWithNullUserId)) <= $amountWalletAdd) {
            $insertCLpWallet = $this->insertCLpWallet($count, $amountWalletAdd);
        }
    }

    function insertAndUpdateCLpWallet($count, $amountWalletAdd, $data) {
        $amount = $count + $amountWalletAdd;
        $addressArr = [];
        for ($i = 0; $i < $amount; $i++) {
            $result = $this->clpwalletapi->generateWallet();
            if ($result['success']) {
                $addressArr[] = $result['address'];
            }
        }
        //update
        foreach ($data as $id) {
            $newClpwallet = CLPWallet::find($id);
            $newClpwallet->address = $this->helper->removeAndGetOneElementOfArray($addressArr);
            $newClpwallet->save();
        }
        //insert
        $dataInsert = array();
        foreach ($addressArr as $addr) {
            $dataInsert[]['address'] = $addr;
            $dataInsert[]['created_at'] = $this->helper->getTimeNow();
            $dataInsert[]['udpated_at'] = $this->helper->getTimeNow();
        }

        return ($this->clpwalletapi->insert($dataInsert));
    }

    function insertClpWallet($count, $amountWalletAdd) {
        for ($i = 0; $i < $amount = $amountWalletAdd - $count; $i++) {
            $result = $this->clpwalletapi->generateWallet();
            if ($result) {
                //get
                for ($i = 0; $i < $amount; $i++) {
                    $result = $this->clpwalletapi->generateWallet();
                    if ($result['success']) {
                        $addressArr[] = $result['address'];
                    }
                }
                //insert
                $dataInsert = array();
                foreach ($addressArr as $addr) {
                    $dataInsert[]['address'] = $addr;
                    $dataInsert[]['created_at'] = $this->helper->getTimeNow();
                    $dataInsert[]['udpated_at'] = $this->helper->getTimeNow();
                }

                $this->clpwallet->insert($dataInsert);
            }
        }
    }

}
