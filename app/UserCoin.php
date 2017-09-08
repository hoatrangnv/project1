<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class UserCoin extends Model
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
        'userId', 'accountCoinBase', 'walletAddress', 'btcCoinAmount', 'clpCoinAmount', 'usdAmount', 'reinvestAmount','backupKey'
    ];
    
    public function user() {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
