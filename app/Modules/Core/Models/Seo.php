<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Base\Traits\Cacheable;

class Seo extends Model
{
    use Cacheable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'core_seo';
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'page_id',
        'domain_id',
        'url',
        'title',
        'description',
        'keywords',
        'h1',
        'header_text',
        'footer_text',
        'breadc_label',
        'breadc_title', 
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