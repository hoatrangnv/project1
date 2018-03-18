<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ExchangeRate extends Model
{
    use SoftDeletes;

    /** 
     *Define currency
     */
    const USD = 'usd';
    const BTC = 'btc';
    const CLP = 'clp';
    
    public $timestamps = true;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exchange_rates';
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'from_currency',
        'exchrate',
        'to_currency',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
    
    protected $primaryKey = 'id';
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('exchange_rates');
    }
    
    public static function getExchRate(){
        
        $data = DB::table('exchange_rates')
                ->select('exchrate')
                ->where([
                    ["from_currency" , "=" , "btc"],
                    ["to_currency" , "=" , "usd"],
                ])
                ->orWhere([
                    ["from_currency" , "=" , "clp"],
                    ["to_currency" , "=" , "usd"],
                ])
                ->orWhere([
                    ["from_currency" , "=" , "clp"],
                    ["to_currency" , "=" , "btc"],
                ])
                ->orderby('id','DESC')
                ->limit(3)
                ->get();

        $data1 = array_merge( json_decode($data), json_decode($data) );
        

        if( Config('params.fixCLPUSD') ) {
            $clpbtc = $data[0]->exchrate ;
            $btcusd = $data[1]->exchrate ;
            $clpusd = $data[2]->exchrate ;
            foreach($data1 as $index => $d) {
                if($index == 0 ) {
                    $d->exchrate = (($clpusd>1) ? $clpusd : 1) / $btcusd;
                }
                if($index == 1 ) {
                    $d->exchrate = $btcusd;
                }
                if($index == 2 ) {
                    $d->exchrate = ($clpusd>1) ? $clpusd : 1;
                }
            }
        }

        return response()->json( $data1 );
        
    }

    public static function getExchRateCLPBTC(){
        $data = DB::table('exchange_rates')
            ->select('exchrate')
            ->where([
                ["from_currency" , "=" , "btc"],
                ["to_currency" , "=" , "usd"],
            ])
            ->orderby('id','DESC')
            ->first();

        return $data->exchrate;

    }

    public static function getCLPUSDRate(){
        
        $data = DB::table('exchange_rates')
                ->select('exchrate')
                ->where([
                    ["from_currency" , "=" , "clp"],
                    ["to_currency" , "=" , "usd"],
                ])
                ->limit(1)
                ->get();
        
        return $data[0]->exchrate;
        
    }

    public static function getBTCUSDRate(){
        
        $data = DB::table('exchange_rates')
                ->select('exchrate')
                ->where([
                    ["from_currency" , "=" , "btc"],
                    ["to_currency" , "=" , "usd"],
                ])
                ->limit(1)
                ->get();
        
        return $data[0]->exchrate;
        
    }

    public static function getCLPBTCRate(){
        
        $data = DB::table('exchange_rates')
                ->select('exchrate')
                ->where([
                    ["from_currency" , "=" , "clp"],
                    ["to_currency" , "=" , "btc"],
                ])
                ->limit(1)
                ->get();
        
        return $data[0]->exchrate;
    }

    public static function getExchangeTable() {

        $ExchangeTable = [];
        $rate = ExchangeRate::getCLPUSDRate();
        switch ($rate) {
            case ($rate>=0.1&&$rate<0.2):
                $ExchangeTable = [500,2500,5000,10000,25000,50000];
                break;
            case ($rate>=0.2&&$rate<0.3):
                $ExchangeTable = [280,1400,2800,5600,14000,28000];
                break;
            case ($rate>=0.3&&$rate<0.4):
                $ExchangeTable = [200,1000,2000,4000,10000,20000];
                break;
            case ($rate>=0.4&&$rate<0.5):
                $ExchangeTable = [160,800,1600,3200,8000,16000];
                break;
            case ($rate>=0.5&&$rate<0.6):
                $ExchangeTable = [140,700,1400,2800,7000,1400];
                break;
            case ($rate>=0.6&&$rate<0.7):
                $ExchangeTable = [130,650,1300,2600,6500,13000];
                break;
            case ($rate>=0.7&&$rate<0.8):
                $ExchangeTable = [120,600,1200,2400,6000,12000];
                break;
            case ($rate>=0.8&&$rate<0.9):
                $ExchangeTable = [110,550,1100,2200,5500,11000];
                break;
            case ($rate>=0.9&&$rate<1.0):
                $ExchangeTable = [100,500,1000,2000,5000,10000];
                break;
        };

        return $ExchangeTable;
    }
}
