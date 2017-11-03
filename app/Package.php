<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    const Tygia = 1;
    protected $fillable = [
		'name', 'thumb', 'price', 'pack_id', 'bonus'
	];
    
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->setTable('packages');
    }
    public function users() {
        return $this->hasMany(UserData::class,  'packageId','id');
    }

}
