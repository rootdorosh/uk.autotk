<?php

namespace App\Modules\Auto\Models;

use App\Base\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model as BaseModel;

class TrimWheel extends BaseModel
{
    use Cacheable;

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_trim_wheel';

    /**
     * @var  bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.

     * @var  array
     */
    public $fillable = [
        'trim_id',
        'front_id',
        'rear_id',
        'is_stock',
        'is_runflat',
        'is_steel_wheels',
        'front_pressure',
        'rear_pressure',
    ];
}
