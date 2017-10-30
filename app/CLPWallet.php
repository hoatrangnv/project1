<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CLPWallet extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'userId', 'address', 'transaction'
    ];
    
    protected $primaryKey = 'id';
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('clp_wallets');
    }
    
    public function getDataToGetClpWalletOne($checkNullUserId){
        $data = $checkNullUserId ? self::whereNull('userId')->whereNotNull('address')->get() : 
            self::whereNotNull('userId')->whereNull('address')->get() ;
        return $data;
    }

    public function userCoin(){
        return $this->hasOne(UserCoin::class, 'userId', 'userId');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
