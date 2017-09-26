<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawConfirm extends Model
{
    protected $fillable = [
        'id', 'created_at', 'updated_at', 'walletAddress', 'userId', 'withdrawAmount', 'type', 'status'
	];
	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('withdraw_confirm');
    }
}
