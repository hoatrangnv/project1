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


    /**
     * Bonus Type
     */
    
    // Fast start bonus
    const FAST_START_TYPE = 1;
    // Lãi <=> Intervest
    const INTEREST_TYPE = 2;
    // Binary bonus <=> hoa hồng cân nhánh
    const BINARY_TYPE = 3;
    // Ltoyalty bonus
    const LTOYALTY_TYPE = 4;
    // Tranfer Usd to Clp
    const USD_CLP_TYPE = 5;
    // Tranfer ReInvest to Clp
    const REINVEST_CLP_TYPE = 6;
    // Tranfer Btc to Clp
    const BTC_CLP_TYPE = 7;
    // Tranfer Clp to Btc
    const CLP_BTC_TYPE = 8;
    // WithDraw BTC
    const WITH_DRAW_BTC_TYPE = 9;
    // Withdraw CLP
    const WITH_DRAW_CLP_TYPE = 10;
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
