<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;
use App\Http\Controllers\Backend\RepoReportController as Report;
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

    public static function getDataReport($date,$opt){
        switch ($opt){
            case Report::DAY_NOW :
                return self::selectRaw('DATE(user_packages.created_at) as date, SUM(user_packages.amount_increase) as totalPrice')
                    ->whereDate('user_packages.created_at','>=', $date['from_date'])
                    ->whereDate('user_packages.created_at','<=', $date['to_date'])
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::WEEK_NOW :
                return self::selectRaw(
        'DATE(user_packages.created_at) AS date, 
                CONCAT(WEEKOFYEAR(user_packages.created_at),YEAR(user_packages.created_at)) AS week_year,
                SUM(user_packages.amount_increase) AS totalPrice')
                    ->whereDate('user_packages.created_at','>=', $date['from_date'])
                    ->whereDate('user_packages.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
            case Report::MONTH_NOW :
                return self::selectRaw(
                    'DATE(user_packages.created_at) AS date, 
                CONCAT(MONTH(user_packages.created_at),YEAR(user_packages.created_at)) AS week_year,
                SUM(user_packages.amount_increase) AS totalPrice')
                    ->whereDate('user_packages.created_at','>=', $date['from_date'])
                    ->whereDate('user_packages.created_at','<=', $date['to_date'])
                    ->groupBy('week_year')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
        }

    }

    public static function countTotalValue($date){
        return self::whereDate('user_packages.created_at','>=', $date['from_date'])
            ->whereDate('user_packages.created_at','<=', $date['to_date'])
            ->sum('user_packages.amount_increase');
    }
}
