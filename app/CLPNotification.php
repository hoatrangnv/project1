<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CLPNotification extends Model
{
    protected $fillable = [
        'id', 'data', 'pending_status', 'transaction_hash', 'completed_status', 'wallet_id', 'created_at', 'updated_at'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('clp_notification');
    }
}
