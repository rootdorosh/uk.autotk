<?php

namespace App\Modules\Core\Services\Fetch;

use App\Modules\Core\Models\Page;
use App\Base\FetchService;
use Cache;

/**
 * Class PageFetchService
 */
class PageFetchService extends FetchService
{    
    /**
     * @param string $alias
     * @return Page|null
     */
    public function byAlias(string $alias): ?Page
    {
        return Cache::tags($this->tag)->remember(
            $this->tag . '_byAlias_' . $alias, 60*60*24, function() use ($alias) {
            
            return $this->model::where('alias', $alias)
                        ->first();
        });        
    } 
    
    /**
     * @param
     * @return array
     */
    public function getList(): array
    {
        return Cache::tags($this->tag)->remember(
            $this->tag . '_getList_', 60*60*24, function() {
            
            return $this->model::orderBy('rank')->get()->pluck('alias', 'id')->toArray();
        });        
    }   
    
}
