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
}
