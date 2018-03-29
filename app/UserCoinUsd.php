<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserCoinUsd extends Model
{
    use Notifiable;
    public $timestamps = false;
    protected $primaryKey = 'userId';
    
    protected $fillable = [
        'userId', 'usdAmountFree', 'usdAmountHold'
    ];

    public function userCoin() {
        return $this->hasOne(UserCoin::class, 'userId', 'userId');
    }

}
