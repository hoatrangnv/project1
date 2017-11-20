<?php
/**
 * Created by PhpStorm.
 * User: huydk
 * Date: 11/20/2017
 * Time: 12:31 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ReadNew extends Model
{
    protected $fillable = [
        'new_id','user_id','read'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('notification_read_new');
    }
}
