<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawConfirm extends Model
{

	protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'created_at', 'updated_at', 'walletAddress', 'userId', 'withdraw_id', 'withdrawAmount', 'type', 'status'
	];
	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('withdraw_confirm');
    }

    public function users() {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
