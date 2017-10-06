<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonusBinary extends Model
{
    protected $fillable = [
		'userId', 'weeked', 'year', 'leftNew', 'rightNew', 'leftOpen', 'rightOpen', 'settled', 'bonus', 'weekYear', 'bonus_tmp'
	];
	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('bonus_binary');
    }
    public function userData() {
        return $this->hasOne(UserData::class, 'userId', 'userId');
    }

    public function userCoin() {
        return $this->hasOne(UserCoin::class, 'userId', 'userId');
    }
}
