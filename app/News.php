<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    
    use SoftDeletes;
    /** 
     *Define category 
     */
    const CRYPTO = 1 ;
    const BLOCKCHAIN = 2;
    const CLP = 3;
    const P2P = 4;
    
    public $timestamps = true;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news';
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'category_id',
        'image',
        'short_desc',
        'desc',
        'public_at',
        'created_by',
        'priority',
        'views',
        "created_at",
        "updated_at",
        "deleted_at"
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
    
    protected $primaryKey = 'id';
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable('news');
    }
}
