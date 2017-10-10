<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
        'id', 'created_at', 'updated_at', 'walletAddress', 'userId', 'amountUSD', 'wallet_id', 'transaction_id', 'transaction_hash', 'fee', 'detail', 'status'
	];
	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('withdraws');
    }
}
