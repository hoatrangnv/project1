<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    protected $primaryKey = null;
    protected $fillable = [
		'userId', 'packageId', 'amount_increase', 'buy_date', 'release_date'
	];
    
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->setTable('user_packages');
    }
}
