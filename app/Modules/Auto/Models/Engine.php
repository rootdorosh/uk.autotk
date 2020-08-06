<?php

namespace App\Modules\Auto\Models;

use App\Base\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Engine extends BaseModel
{
    use Cacheable;
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_engine';

    /**
     * @var  bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.

     * @var  array
     */
    public $fillable = [
        'title',
    ];
}
