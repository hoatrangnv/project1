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
        
        return response()->json( $data );
        
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
}
