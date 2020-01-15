<?php

namespace App\Modules\Core\Services\Fetch;

use Illuminate\Support\Collection;
use App\Modules\Core\Models\{
    Domain,
    Page,
    Banner
};
use App\Base\FetchService;
use Cache;

/**
 * Class BannerFetchService
 */
class BannerFetchService extends FetchService
{    
    /**
     * @return Collection
     */
    public function getData(): Collection
    {
        $key = $this->tag . '_getData_';
        
        return Cache::tags($this->tag)->remember($key, 60*60*24, function() {
            return $this->model::with('page')->get();
        });        
    } 

    /**
     * @param Domain $domain
     * @param array
     * @return Banner|null
     */
    public function byDomainAndPage(Domain $domain, Page $page): array
    {
        return $this->getData()->reject(function ($item) use ($domain, $page) {
            return !($item->page_id === $page->id && $item->domain_id === $domain->id);
        })
        ->pluck('content', 'position')
        ->toArray();        
    } 
}
