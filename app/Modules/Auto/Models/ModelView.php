<?php

namespace App\Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class ModelView extends BaseModel
{    
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_model_views';
    
    /**
     * @var  bool
     */
    public $timestamps = false;
	
    /*
     * @var  array
     */
    public $fillable = [
        'model_id',
        'domain_id',
    ];
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // auto-sets values on creation
        static::creating(function ($query) {
            $query->create_time = time();
        });
    }    
}
