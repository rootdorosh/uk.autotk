<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Translatable\Translatable;
use App\Base\Traits\Cacheable;

class Domain extends Model
{
    use Translatable, Cacheable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'core_domains';
    
    /**
     * @var  string
     */
	public $translationForeignKey = 'domain_id';	

    /*
     * @var  array
     */
    public $translatedAttributes = [
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
        'alias',
        'is_active',
        'lang',
        'code',
        'rank', 
    ];  
     
}