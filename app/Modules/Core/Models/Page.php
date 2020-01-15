<?php 

declare( strict_types = 1 );

namespace App\Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Base\Traits\{
    Cacheable,
    RelationMap
};

class Page extends Model
{
    use RelationMap, Cacheable;
    
    /**
     * @var  bool
     */
    public $timestamps = false;

    /*
     * @var  string
     */
    public $table = 'core_pages';
    
    /**
     * @var  array
     */
    public $fillable = [
        'alias',
        'title', 
        'params', 
    ];  
  
    /**
     * @var  array
     */
    public $casts = [
        'alias' => 'string',
        'title' => 'string', 
        'params' => 'array', 
    ];  
  
    /**
     * @return HasMany
     */
    public function seo(): HasMany
    {
        return $this->hasMany(
            'App\Modules\Core\Models\Seo'
        );
    }
    
    /**
     * @return HasMany
     */
    public function banners(): HasMany
    {
        return $this->hasMany(
            'App\Modules\Core\Models\Banner'
        );
    }
    
    /*
     * @return array
     */
    public function getDataRelationSeo(): array
    {
        $data = [];
        foreach ($this->seo as $item) {
            $data[$item->domain_id] = $item->toArray();
        }
        
        return $data;
    }
     
    /*
     * @return array
     */
    public function getDataRelationBanners(): array
    {
        $data = [];
        foreach ($this->banners as $item) {
            $data[$item->domain_id][$item->position] = $item->content;
        }
        
        //dd($data);
        
        return $data;
    }
     
}