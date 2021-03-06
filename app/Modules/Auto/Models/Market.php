<?php

namespace App\Modules\Auto\Models;

use App\Base\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model;
use App\Services\Translatable\Translatable;

class Market extends Model
{
    use Translatable, Cacheable;

    const EUDM = 3;

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_market';

    /**
     * @var  bool
     */
    public $timestamps = false;

    /**
     * @var  string
     */
	public $translationForeignKey = 'market_id';

    /*
     * @var  array
     */
    public $translatedAttributes = [
        'is_translated',
        'title',
    ];

    /*
     * @var  array
     */
    protected $with = ['translations'];

    /**
     * The attributes that are mass assignable.

     * @var  array
     */
    public $fillable = [
        'is_active',
        'slug',
        'abbr',
    ];
}
