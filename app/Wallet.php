<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'walletType', 'type', 'note', 'inOut', 'userId', 'amount'
    ];

    // Wallet Type
    const USD_WALLET = 1;

    const BTC_WALLET = 2;

    const CLP_WALLET = 3;

    const REINVEST_WALLET = 4;


    // Bonus Type
    const FAST_START_TYPE = 1;

    const INTEREST_TYPE = 2;

    const BINARY_TYPE = 3;

    const LTOYALTY_TYPE = 4;

    const USD_CLP_TYPE = 5;

    const REINVEST_CLP_TYPE = 6;

    const BTC_CLP_TYPE = 7;

    const CLP_BTC_TYPE = 8;
    
    //inOut 
    const IN = "in" ;
    
    const OUT = "out";
    
    //Hạn mức tối thiều 
    const MIN_TRANFER_USD_CLP = 10;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('wallets');
    }
}
