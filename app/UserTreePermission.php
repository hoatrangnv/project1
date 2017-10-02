<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class UserTreePermission extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'userId';
    protected $fillable = [
        'userId', 'binary', 'genealogy', 'binary_total', 'genealogy_total'
    ];
    public function user() {
        return $this->hasOne(User::class, 'id', 'userId');
    }
    public function userCoin() {
        return $this->hasOne(UserCoin::class, 'userId', 'userId');
    }
    public function userData() {
        return $this->hasOne(UserData::class, 'userId', 'userId');
    }
}
