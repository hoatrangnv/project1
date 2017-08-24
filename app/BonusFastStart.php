<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonusFastStart extends Model
{
    protected $fillable = [
		'userId', 'generation', 'partnerId', 'amount'
	];
	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('bonus_fastStart');
    }
    public function users() {
        return $this->hasOne(User::class, 'id', 'partnerId');
    }
}
