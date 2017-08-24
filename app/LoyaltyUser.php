<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoyaltyUser extends Model
{
    protected $fillable = [
		'userId', 'isSilver', 'isGold', 'isPear', 'isEmerald', 'isDiamond', 'f1Left', 'f1Right'
	];
	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('users_loyalty');
    }
}
