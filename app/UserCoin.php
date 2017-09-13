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
    protected $fillable = [
        'userId', 'accountCoinBase', 'walletAddress', 'btcCoinAmount', 'clpCoinAmount', 'usdAmount', 'reinvestAmount'
    ];
    public function user() {
        return $this->hasOne(User::class, 'id', 'userId');
    }
}
