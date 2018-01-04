<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 1/3/2018
 * Time: 9:52 AM
 */

namespace App\Http\Middleware;
use Auth;
use Carbon\Carbon;
use DateTime;
use App\UserTreePermission;
use Closure;

class HoldingUser
{
    protected $holding_user,
        $list,$enable_date,
        $disable_date,$country;

    public function __construct()
    {
        $this->holding_user = config('holding_user.holding_user');
        $this->list = array_map('intval', explode(',', config('holding_user.holding_user_list')));
        $this->enable_date = config('holding_user.holding_user_enable_date');
        $this->disable_date = config('holding_user.holding_user_disable_date');
        $this->country = config('holding_user.holding_user_country');
    }

    public function __invoke()
    {
        $this->action();
    }

    public function __call($method, $arguments) {
        $prop = lcfirst(substr($method, 5));
        if( !property_exists($this, $prop) ){
            throw new \Exception('Property '. $prop . ' does not exist');
        }
        return $this->$prop;
    }

    public function handle($request, Closure $next){
        if ($this->action()){
            return abort(404);
        }else{
            return $next($request);
        }
    }

    public function action(){

            if (!$this->holding_user) {
                return false;
            }

            if (!$this->list[0]) {
                return false;
            }

            if (is_null($this->enable_date) || is_null($this->disable_date)
                || !$this->verifyDate($this->enable_date) || !$this->verifyDate($this->disable_date)){
                return false;
            }

            $now = Carbon::now();
            $enableDate = Carbon::createFromFormat('d-m-Y',$this->enable_date)->setTime(00,00,00,00);
            $disableDate = Carbon::createFromFormat('d-m-Y',$this->disable_date)->setTime(00,00,00,00);
            //nếu ngày enable lớn hớn ngày disable return false
            if ($enableDate->gt($disableDate))
                return false;

            if ($now->gte($enableDate) && $now->lt($disableDate)){

                $userlist = UserTreePermission::select('genealogy')->whereIn('userId',$this->list)->get();
                $user = array();

                foreach ($userlist as $value){
                    $user = array_merge($user,array_map('intval',explode(',',$value->genealogy)));
                }

                if (in_array(Auth::user()->id,$user) && Auth::user()->country == $this->country )
                    return true;

                return false;

            }

            return false;

    }

    public function verifyDate($date)
    {
        return (DateTime::createFromFormat('d-m-Y', $date) !== false);
    }

}