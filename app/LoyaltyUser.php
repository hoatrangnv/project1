<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoyaltyUser extends Model
{
    public $timestamps = false;
    protected $fillable = [
		'userId', 'isSilver', 'isGold', 'isPear', 'isEmerald', 'isDiamond', 'f1Left', 'f1Right', 'refererId', 'leftRight'
	];
	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('users_loyalty');
    }
    public function user() {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
