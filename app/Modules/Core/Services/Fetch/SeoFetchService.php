<?php

namespace App\Modules\Core\Services\Fetch;

use Illuminate\Support\Collection;
use App\Modules\Core\Models\{
    Domain,
    Page,
    Seo
};
use App\Base\FetchService;
use Cache;

/**
 * Class SeoFetchService
 */
class SeoFetchService extends FetchService
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
     * @param Page $page
     * @return Seo|null
     */
    public function byDomainAndPage(Domain $domain, Page $page):? Seo
    {
        return $this->getData()->reject(function ($item) use ($domain, $page) {
            return !($item->page_id === $page->id && $item->domain_id === $domain->id);
        })->first();        
    } 

    /**
     * @param Domain $domain
     * @param string $pageAlias
     * @return Seo|null
     */
    public function byDomainAndPageAlias(Domain $domain, string $pageAlias):? Seo
    {
        return $this->getData()->reject(function ($item) use ($domain, $pageAlias) {
            return !($item->page->alias === $pageAlias && $item->domain_id === $domain->id);
        })->first();        
    } 

    /**
     * @param Domain $domain
     * @return array
     */
    public function getDomainUrlMap(Domain $domain): array
    {
        return $this->getData()->reject(function ($item) use ($domain) {
            return !($item->domain_id === $domain->id);
        })
        ->pluck('url', 'page.alias')
        ->toArray();        
    } 
    
    /**
     * @param Domain $domain
     * @param string $pageAlias
     * @param string $seoAttribute
     * @param array $params
     * @return string
     */
    public function getSeoParamByPage(
        Domain $domain, 
        string $pageAlias, 
        string $seoAttribute, 
        array $params = []
    ):? string
    {
        $seoValue =  $this->getData()->reject(function ($item) use ($domain, $pageAlias) {
            return !($item->page->alias === $pageAlias && $item->domain_id === $domain->id);
        })->first()->$seoAttribute; 
        
        foreach ($params as $key => $val) {
            $seoValue = str_replace("[{$key}]", $val, $seoValue);
        }
        
        return $seoValue;
    } 
    
}
