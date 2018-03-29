<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

use Log;

class UserData extends Model
{
    use HasRoles;
    use Notifiable;
    public $timestamps = false;
    protected $primaryKey = 'userId';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId', 'refererId', 'accountCoinBase', 'walletAddress', 'packageId', 'packageDate', 'isBinary', 'leftRight', 'totalBonusLeft', 'totalBonusRight', 'binaryUserId', 'lastUserIdLeft', 'lastUserIdRight', 'leftMembers', 'rightMembers', 'totalMembers',
    ];
    public function user() {
        return $this->hasOne(User::class, 'id', 'userId');
    }
    public function userCoin() {
        return $this->hasOne(UserCoin::class, 'userId', 'userId');
    }
    public function package() {
        return $this->hasOne(Package::class, 'id', 'packageId');
    }
    public function userTreePermission() {
        return $this->hasOne(UserTreePermission::class, 'userId', 'userId');
    }

    public function get_data_for_pie_chart($date) {

        return self::selectRaw('packages.name as name, COUNT(user_datas.userId) as totalPerson')
            ->join('packages', 'packages.id', 'user_datas.packageId')
            ->whereDate('user_datas.packageDate','>=', $date['from_date'])
            ->whereDate('user_datas.packageDate','<=', $date['to_date'])
            ->groupBy('packages.name')
            ->get()
            ->toArray();
    }

    /**
     * This function checks returns a list of the uplines of current user in a collecitons
     * $this->upLines() or
     * $this->upLines()->reverse()
     */
    public function genalogy_upLines()
    {
        $uplines = $this->where('userId', '=', $this->binaryUserId)->get();
    
        while ($uplines->last() && !($uplines->last()->binaryUserId == null || empty($uplines->last()->binaryUserId)))
        {
            $parent = $this->where('userId', '=', $uplines->last()->binaryUserId)->get();
            $uplines = $uplines->merge($parent);
        }

        return $uplines;
    }

}
