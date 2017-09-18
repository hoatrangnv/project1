<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
		'walletType', 'type', 'note', 'inOut', 'userId', 'amount'
	];

	// Wallet Type
	const usdWallet = 1;

	const btcWallet = 1;

	const clpWallet = 1;

	const reinvestWallet = 4;


	// Bonus Type
	const fastStartBonusType = 4;

	const interestType = 2;

	const binaryBonusType = 4;

	const loyaltyType = 4;

	const transerType = 4;

	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('wallets');
    }
}
