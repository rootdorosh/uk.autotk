<?php

namespace App\Modules\Auto\Services\Fetch;

use Illuminate\Support\Collection;
use App\Modules\Auto\Models\Make;
use App\Modules\Auto\Models\Lang\MakeLang;
use App\Modules\Core\Models\Domain;
use App\Base\FetchService;
use Cache;
use FrontPage;

/**
 * Class MakeFetchService
 */
class MakeFetchService extends FetchService
{    
    /**
     * @return array
     */
    public function getData(): array
    {
        $key = $this->tag . '_getData_' . l();
        
        return Cache::tags($this->tag)->remember($key, self::EXP_MONTH, function() {
            $items = MakeLang::query()
                ->translation()
                ->with('make')
                ->where('auto_make.is_active', 1)
                ->orderBy('auto_make.slug')
                ->get();
            
            $data = [];
            foreach ($items as $item) {
                $data[] = [
                    'id' => $item->make->id,
                    'slug' => $item->make->slug,
                    'title' => $item->title,
                ];
            }
            
            return $data;
        });        
    }
    
    /**
     * @param string $slug
     * @return array|null
     */
    public function getItemBySlug(string $slug):? array
    {
        $key = $this->tag . '_getItemBySlug_' . $slug . '_' . l();
        
        return Cache::tags($this->tag)->remember($key, self::EXP_MONTH, function() use($slug) {
            $item = MakeLang::query()
                ->translation()
                ->with('make')
                ->where('auto_make.is_active', 1)
                ->where('auto_make.slug', $slug)
                ->first();
            
            $data = null;
            if ($item !== null) {
                $data = [
                    'id' => $item->make->id,
                    'slug' => $item->make->slug,
                    'title' => $item->title,
                ];
            }
           
            return $data;
        });        
    } 
    
}
