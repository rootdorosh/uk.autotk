<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Base\Traits\Cacheable;

class Banner extends Model
{
    use Cacheable;
    
    const POSITIONS = [
        'horizontal1', 
        'horizontal2', 
        'vertical1', 
        'vertical2',
    ];
    
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'core_banners';
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'page_id',
        'domain_id',
        'position',
        'content', 
    ];  
  
    /**
     * Get the page.
     *
     * @return  BelongsTo
     */
    public function page() : BelongsTo
    {
        return $this->belongsTo('App\Modules\Core\Models\Page');
    }
   
    /**
     * Get the domain.
     *
     * @return  BelongsTo
     */
    public function domain() : BelongsTo
    {
        return $this->belongsTo('App\Modules\Core\Models\Domain');
    }
   
   
     
}