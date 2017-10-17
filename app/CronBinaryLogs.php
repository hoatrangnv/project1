<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class CronBinaryLogs extends Model
{
 
    protected $primaryKey = 'id';

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->setTable('cron_binary_logs');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['userId', 'status'];

}
