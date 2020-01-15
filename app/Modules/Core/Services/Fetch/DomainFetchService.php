<?php

namespace App\Modules\Core\Services\Fetch;

use Illuminate\Support\Collection;
use App\Modules\Core\Models\Domain;
use App\Base\FetchService;
use Cache;

/**
 * Class DomainFetchService
 */
class DomainFetchService extends FetchService
{    
    /**
     * @return Collection
     */
    public function getData(): Collection
    {
        $key = $this->tag . '_getData_';
        
        return Cache::tags($this->tag)->remember($key, 60*60*24, function() {
            return $this->model::get();
        });        
    } 


    /**
     * @param string $alias
     * @return Domain|null
     */
    public function byAlias(string $alias): ?Domain
    {
        return Cache::tags($this->tag)->remember(
            $this->tag . '_byAlias_' . $alias, 60*60*24, function() use ($alias) {
            
            return $this->model::where('alias', $alias)
                        ->where('is_active', 1)
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
