<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonusFastStart extends Model
{
    protected $fillable = [
		'userId', 'generation', 'partnerId', 'packageId', 'amount'
	];
	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('bonus_faststart');
    }
    public function users() {
        return $this->hasOne(User::class, 'id', 'partnerId');
    }
    public function package() {
        return $this->hasOne(Package::class, 'id', 'packageId');
    }
    
}
