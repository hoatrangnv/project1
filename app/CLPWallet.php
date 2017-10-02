<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CLPWallet extends Model
{
    protected $fillable = [
        'userId', 'address'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('clp_wallets');
    }
}
