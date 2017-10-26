<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
class UserPackage extends Model
{
    protected $primaryKey = "id";
    public $incrementing = true;
    protected $fillable = [
        'userId', 
        'packageId', 
        'amount_increase', 
        'buy_date', 
        'release_date', 
        'weekYear',
        'dt',
	];
    
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->setTable('user_packages');
    }
    
    public static function getHistoryPackage(){
        $package = new UserPackage;
        $tableName = $package->getTable();
        $data = $package->select("$tableName.id","$tableName.buy_date","$tableName.release_date","packages.name")
                ->where("userId",Auth::user()->id)
                ->join("packages","packages.id","=","$tableName.packageId")
                ->get();
                
        return $data;
    }
    
    public function package(){
        return $this->hasOne(Package::class, 'id', 'packageId');
    }

    public static function getDataReport($firstDay, $endDay){
        return self::selectRaw('user_packages.created_at as date, SUM(packages.price) as totalPrice')
            ->join('packages', 'packages.id', 'user_packages.packageId')
            ->whereDate('user_packages.created_at','>=', $firstDay)
            ->whereDate('user_packages.created_at','<=', $endDay)
            ->groupBy('user_packages.created_at')
            ->get()
            ->toArray();
    }
}
