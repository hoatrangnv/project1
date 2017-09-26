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
        'userId', 'binary', 'genealogy'
    ];
    public function user() {
        return $this->hasOne(User::class, 'id', 'userId');
    }
    public function userCoin() {
        return $this->hasOne(UserCoin::class, 'userId', 'userId');
    }
}
