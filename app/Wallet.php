<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Backend\Report\RepoReportController as Report;


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
    // matching bonus
    const MATCHING_TYPE = 17;
    //inOut 

    // Transfer USD from one user to another
    const TRANSFER_USD_TYPE = 18;

    const IN = "in" ;
    
    const OUT = "out";
    
    //Hạn mức tối thiều 
    const MIN_TRANFER_USD_CLP = 10;
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('wallets');
    }

    /*
     * Get data for report Commission
     * */
    public static function getDataReport($date,$opt){
        switch ($opt){
            case Report::DAY_NOW :
                return self::selectRaw('type, DATE(wallets.created_at) as date, SUM(wallets.amount) as totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::USD_WALLET)
                    ->whereIn('type',[self::FAST_START_TYPE,self::INTEREST_TYPE,
                        self::BINARY_TYPE,self::LTOYALTY_TYPE,self::MATCHING_TYPE])
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('type')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->orderBy('type')
                    ->get()
                    ->toArray();
            case Report::WEEK_NOW :
                return self::selectRaw('type, CONCAT(WEEKOFYEAR(wallets.created_at),"-",YEAR(wallets.created_at)) as date, SUM(wallets.amount) as totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::USD_WALLET)
                    ->whereIn('type',[self::FAST_START_TYPE,self::INTEREST_TYPE,
                        self::BINARY_TYPE,self::LTOYALTY_TYPE,self::MATCHING_TYPE])
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('type')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->orderBy('type')
                    ->get()
                    ->toArray();
            case Report::MONTH_NOW :
                return self::selectRaw('type, CONCAT(MONTH(wallets.created_at),"-",YEAR(wallets.created_at)) as date, SUM(wallets.amount) as totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::USD_WALLET)
                    ->whereIn('type',[self::FAST_START_TYPE,self::INTEREST_TYPE,
                        self::BINARY_TYPE,self::LTOYALTY_TYPE,self::MATCHING_TYPE])
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('type')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->orderBy('type')
                    ->get()
                    ->toArray();
        }
    }
    /*Get DATA for BTC DEPOSIT Report*/
    public static function getDataForBtcDepositReport($date,$opt){
        switch ($opt){
            case Report::DAY_NOW :
                return self::selectRaw('DATE(wallets.created_at) as date, SUM(wallets.amount) as totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::BTC_WALLET)
                    ->where('type',self::DEPOSIT_BTC_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::WEEK_NOW :
                return self::selectRaw(
                    'DATE(wallets.created_at) AS date, 
                CONCAT(WEEKOFYEAR(wallets.created_at),YEAR(wallets.created_at)) AS week_year,
                SUM(wallets.amount) AS totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::BTC_WALLET)
                    ->where('type',self::DEPOSIT_BTC_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::MONTH_NOW :
                return self::selectRaw(
                    'DATE(wallets.created_at) AS date, 
                CONCAT(MONTH(wallets.created_at),YEAR(wallets.created_at)) AS week_year,
                SUM(wallets.amount) AS totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::BTC_WALLET)
                    ->where('type',self::DEPOSIT_BTC_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
        }
    }

    public static function getTotalBtcDeposit($date){
        return self::where('inOut','in')
            ->where('walletType',self::BTC_WALLET)
            ->where('type',self::DEPOSIT_BTC_TYPE)
            ->whereDate('wallets.created_at','>=', $date['from_date'])
            ->whereDate('wallets.created_at','<=', $date['to_date'])
            ->sum('wallets.amount');
    }
    /*Get DATA for BTC WithDraw Report*/
    public static function getDataForBtcWithDrawReport($date,$opt){
        switch ($opt){
            case Report::DAY_NOW :
                return self::selectRaw('DATE(wallets.created_at) as date, SUM(wallets.amount) as totalPrice')
                    ->where('inOut','out')
                    ->where('walletType',self::BTC_WALLET)
                    ->where('type',self::WITH_DRAW_BTC_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::WEEK_NOW :
                return self::selectRaw(
                    'DATE(wallets.created_at) AS date, 
                CONCAT(WEEKOFYEAR(wallets.created_at),YEAR(wallets.created_at)) AS week_year,
                SUM(wallets.amount) AS totalPrice')
                    ->where('inOut','out')
                    ->where('walletType',self::BTC_WALLET)
                    ->where('type',self::WITH_DRAW_BTC_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::MONTH_NOW :
                return self::selectRaw(
                    'DATE(wallets.created_at) AS date, 
                CONCAT(MONTH(wallets.created_at),YEAR(wallets.created_at)) AS week_year,
                SUM(wallets.amount) AS totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::BTC_WALLET)
                    ->where('type',self::WITH_DRAW_BTC_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
        }
    }

    public static function getTotalBtcWithDraw($date){
        return self::where('inOut','out')
            ->where('walletType',self::BTC_WALLET)
            ->where('type',self::WITH_DRAW_BTC_TYPE)
            ->whereDate('wallets.created_at','>=', $date['from_date'])
            ->whereDate('wallets.created_at','<=', $date['to_date'])
            ->sum('wallets.amount');
    }
    /*Get DATA for CLP Deposit Report*/
    public static function getDataForClpDepositReport($date,$opt){
        switch ($opt){
            case Report::DAY_NOW :
                return self::selectRaw('DATE(wallets.created_at) as date, SUM(wallets.amount) as totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::CLP_WALLET)
                    ->where('type',self::DEPOSIT_CLP_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::WEEK_NOW :
                return self::selectRaw(
                    'DATE(wallets.created_at) AS date, 
                CONCAT(WEEKOFYEAR(wallets.created_at),YEAR(wallets.created_at)) AS week_year,
                SUM(wallets.amount) AS totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::CLP_WALLET)
                    ->where('type',self::DEPOSIT_CLP_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::MONTH_NOW :
                return self::selectRaw(
                    'DATE(wallets.created_at) AS date, 
                CONCAT(MONTH(wallets.created_at),YEAR(wallets.created_at)) AS week_year,
                SUM(wallets.amount) AS totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::CLP_WALLET)
                    ->where('type',self::DEPOSIT_CLP_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
        }
    }

    public static function getTotalClpDeposit($date){
        return self::where('inOut','in')
            ->where('walletType',self::CLP_WALLET)
            ->where('type',self::DEPOSIT_CLP_TYPE)
            ->whereDate('wallets.created_at','>=', $date['from_date'])
            ->whereDate('wallets.created_at','<=', $date['to_date'])
            ->sum('wallets.amount') ;
    }
    /*Get DATA for CLP WithDraw Report*/
    public static function getDataForClpWithDrawReport($date,$opt){
        switch ($opt){
            case Report::DAY_NOW :
                return self::selectRaw('DATE(wallets.created_at) as date, SUM(wallets.amount) as totalPrice')
                    ->where('inOut','out')
                    ->where('walletType',self::CLP_WALLET)
                    ->where('type',self::WITH_DRAW_CLP_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::WEEK_NOW :
                return self::selectRaw(
                    'DATE(wallets.created_at) AS date, 
                CONCAT(WEEKOFYEAR(wallets.created_at),YEAR(wallets.created_at)) AS week_year,
                SUM(wallets.amount) AS totalPrice')
                    ->where('inOut','out')
                    ->where('walletType',self::CLP_WALLET)
                    ->where('type',self::WITH_DRAW_CLP_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::MONTH_NOW :
                return self::selectRaw(
                    'DATE(wallets.created_at) AS date, 
                CONCAT(MONTH(wallets.created_at),YEAR(wallets.created_at)) AS week_year,
                SUM(wallets.amount) AS totalPrice')
                    ->where('inOut','out')
                    ->where('walletType',self::CLP_WALLET)
                    ->where('type',self::WITH_DRAW_CLP_TYPE)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
        }
    }

    public static function getTotalClpWithDraw($date){
        return self::where('inOut','out')
            ->where('walletType',self::CLP_WALLET)
            ->where('type',self::WITH_DRAW_CLP_TYPE)
            ->whereDate('wallets.created_at','>=', $date['from_date'])
            ->whereDate('wallets.created_at','<=', $date['to_date'])
            ->sum('wallets.amount');
    }
    /*Get Total Sell CLp Report*/
    public static function getDataForTotalSellCLPReport($date,$opt){
        switch ($opt){
            case Report::DAY_NOW :
                return self::selectRaw('DATE(wallets.created_at) as date, SUM(wallets.amount) as totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::CLP_WALLET)
                    ->where('type',self::MIN_TRANFER_USD_CLP)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::WEEK_NOW :
                return self::selectRaw(
                    'DATE(wallets.created_at) AS date, 
                CONCAT(WEEKOFYEAR(wallets.created_at),YEAR(wallets.created_at)) AS week_year,
                SUM(wallets.amount) AS totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::CLP_WALLET)
                    ->where('type',self::MIN_TRANFER_USD_CLP)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::MONTH_NOW :
                return self::selectRaw(
                    'DATE(wallets.created_at) AS date, 
                CONCAT(MONTH(wallets.created_at),YEAR(wallets.created_at)) AS week_year,
                SUM(wallets.amount) AS totalPrice')
                    ->where('inOut','in')
                    ->where('walletType',self::CLP_WALLET)
                    ->where('type',self::MIN_TRANFER_USD_CLP)
                    ->whereDate('wallets.created_at','>=', $date['from_date'])
                    ->whereDate('wallets.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
        }
    }

    public static function getTotalSellCLPReport($date){
        return self::where('inOut','in')
            ->where('walletType',self::CLP_WALLET)
            ->where('type',self::MIN_TRANFER_USD_CLP)
            ->whereDate('wallets.created_at','>=', $date['from_date'])
            ->whereDate('wallets.created_at','<=', $date['to_date'])
            ->sum('wallets.amount');
    }
}
