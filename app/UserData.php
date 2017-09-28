<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

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
}
