<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class UserPackage extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
		'userId', 'packageId', 'amount_increase', 'buy_date', 'release_date', 'weekYear'
	];
    
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->setTable('user_packages');
    }
    
    public static function getHistoryPackage(){
        $package = new UserPackage;
        $tableName = $package->getTable();
        $data = $package->select("packages.name","buy_date","release_date")
                ->where("userId",Auth::user()->id)
                ->join("packages","packages.id","=","$tableName.packageId")
                ->get();
                
        return $data;
    }
}
