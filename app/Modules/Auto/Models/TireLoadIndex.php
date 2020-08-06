<?php

namespace App\Modules\Auto\Models;

use App\Base\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model as BaseModel;

class TireLoadIndex extends BaseModel
{
    use Cacheable;

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'tire_load_index';

    /**
     * @var  bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.

     * @var  array
     */
    public $fillable = [
        'pounds',
        'kilograms',
        'index',
    ];
}



