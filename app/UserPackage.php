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
                    ->get()
                    ->toArray();
            case Report::WEEK_NOW :
                $from_date = $date['from_date'];
                $to_date = $date['to_date'];
                return  DB::select("SELECT
                        DATE(tbl.created_at) AS date,
                        WEEKOFYEAR(tbl.created_at) AS week_year,
                        SUM(tbl.amount_increase) AS totalPrice,
                        DATE_ADD(
                                DATE(tbl.created_at),
                                INTERVAL - WEEKDAY(DATE(tbl.created_at)) DAY
                        ) AS first_day_week,
                        DATE_ADD(
                                DATE(tbl.created_at),
                                INTERVAL - -WEEKDAY(DATE(tbl.created_at)) DAY
                        ) AS last_day_week

                FROM
                        user_packages AS tbl
                WHERE
                        DATE(tbl.created_at) >= '$from_date'
                AND DATE(tbl.created_at) < '$to_date'
                GROUP BY
                        week_year
                ORDER BY date");
        }

    }

    public static function countTotalValue($date){
        return self::whereDate('user_packages.created_at','>=', $date['from_date'])
            ->whereDate('user_packages.created_at','<=', $date['to_date'])
            ->sum('user_packages.amount_increase');
    }
}
