<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
		'name', 'thumb', 'price', 'token', 'replication_time', 'bonus'
	];
    
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->setTable('packages');
    }
}
