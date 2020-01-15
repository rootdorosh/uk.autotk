<?php 

declare( strict_types = 1 );

namespace App\Modules\Translation\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;


class Translation extends Model
{
    use Translatable, Cacheable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'translations';
    
    /**
     * @var  string
     */
	public $translationForeignKey = 'trans_id';	

    /*
     * @var  array
     */
    public $translatedAttributes = [
        'value', 
    ];

    /*
     * @var  array
     */
    protected $with = ['translations'];
        
    /**
     * @var  array
     */
    public $fillable = [
        'slug', 
        'params', 
    ];  
  
    /**
     * @var  array
     */
    public $casts = [
        'slug' => 'string', 
        'params' => 'array', 
    ];  
  
     
}