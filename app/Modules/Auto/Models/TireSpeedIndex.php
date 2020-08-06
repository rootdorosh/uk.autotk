<?php

namespace App\Modules\Auto\Models;

use App\Base\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model as BaseModel;

class TireSpeedIndex extends BaseModel
{
    use Cacheable;

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'tire_speed_index';

    /**
     * @var  bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.

     * @var  array
     */
    public $fillable = [
        'code',
        'mph',
        'kmh',
        'rank',
    ];
}



