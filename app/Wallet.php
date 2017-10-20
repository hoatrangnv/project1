<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'walletType', 'type', 'note', 'inOut', 'userId', 'amount', 'updated_at'
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
    // Tranfer holding to Clp
    const REINVEST_CLP_TYPE = 6;
    // Buy CLP by BTC
    const BTC_CLP_TYPE = 7;
    // Sell Clp to Btc
    const CLP_BTC_TYPE = 8;
    // WithDraw BTC
    const WITH_DRAW_BTC_TYPE = 9;
    // Withdraw CLP
    const WITH_DRAW_CLP_TYPE = 10;
    // transfer BTC
    const TRANSFER_BTC_TYPE = 11;//REMOVE
    // transfer CLP
    const TRANSFER_CLP_TYPE = 12; 
    // deposit BTC
    const DEPOSIT_BTC_TYPE = 13;
    // deposit CLP
    const DEPOSIT_CLP_TYPE = 14;
    // buy Package
    const BUY_PACK_TYPE = 15;
    // withdraw Package
    const WITHDRAW_PACK_TYPE = 16;
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
