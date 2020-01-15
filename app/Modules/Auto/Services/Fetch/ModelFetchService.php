<?php

namespace App\Modules\Auto\Services\Fetch;

use Illuminate\Support\Collection;
use App\Modules\Auto\Models\Make;
use App\Modules\Auto\Models\Model;
use App\Modules\Auto\Models\ModelYear;
use App\Modules\Auto\Models\Market;
use App\Modules\Auto\Models\Lang\ModelLang;
use App\Modules\Core\Models\Domain;
use App\Base\FetchService;
use Cache;
use FrontPage;
use DB;

/**
 * Class ModelFetchService
 */
class ModelFetchService extends FetchService
{    
    /**
     * @param in $makeId
     * @param string $slug
     * @return array|null
     */
    public function getItemByMakeIdAndSlug(int $makeId, string $slug):? array
    {
        $key = $this->tag . '_getItemByMakeIdAndSlug_' . $makeId . '_' . $slug . '_' . l();
        
        return Cache::tags($this->tag)->remember($key, self::EXP_MONTH, function() use ($makeId, $slug) {
            $item = ModelLang::query()
                ->translation()
                ->with('model')
                ->where('auto_model.is_active', 1)
                ->where('auto_model.slug', $slug)
                ->where('auto_model.make_id', $makeId)
                ->first();
            
            $data = null;
            if ($item !== null) {
                $data = [
                    'id' => $item->model->id,
                    'slug' => $item->model->slug,
                    'title' => $item->title,
                ];
            }
            
            return $data;
        });        
    } 

    /**
     * @return array
     */
    public function mostVisited(): array
    {
        $domainId = FrontPage::getDomain()->id;
        $key = $this->tag . '_mostVisited_' . $domainId . '_' . l();
        
        $tags = [
            $this->tag,
            (new Make)->tag,
        ];
        
        return Cache::tags($tags)->remember($key, self::EXP_HOUR, function() use ($domainId) {
            $items = ModelLang::select([
                    'auto_model.id AS model_id',
                    'auto_model_lang.title AS model_title',
                    'auto_model.slug AS model_slug',
                    'auto_model.image AS image',
                    'auto_make_lang.title AS make_title',
                    'auto_make.slug AS make_slug',
                    'auto_make.id AS make_id',
                    DB::raw("(
                        SELECT COUNT(*) FROM auto_model_views 
                        WHERE 
                            auto_model_views.model_id = auto_model.id AND 
                            auto_model_views.domain_id = {$domainId}
                            
                    ) AS views")
                ])
                ->translation()
                ->leftJoin('auto_make', 'auto_make.id', '=', 'auto_model.make_id')
                ->leftJoin('auto_make_lang', 'auto_make_lang.make_id', '=', 'auto_make.id')
                ->where('auto_make_lang.is_translated', 1)
                ->where('auto_make_lang.locale', l())
                ->where('auto_make.is_active', 1)
                ->where('auto_model.is_active', 1)
                ->whereNotNull('auto_model.image')
                ->with('model')
                ->orderBy('views', 'DESC')
                ->limit(9)
                ->get();
                
            $data = [];
            foreach ($items as $item) {
                $row = $item->toArray();
                $row['model_image'] = $item->model->getThumb('image', 100, 60, 'resize');
                
                $data[] = $row;
            }
            
            return $data;
        });        
    }
    
    /**
     * List models form page wheels.make
     * 
     * @param in $makeId
     * @return array|null
     */
    public function getItemsByMakeIdWheels(int $makeId):? array
    {
        $key = $this->tag . '__getItemsByMakeIdWheels___' . $makeId . l();
        $tags = [
            $this->tag,
            (new Make)->tag,
            (new ModelYear)->tag,
        ];
        
        return Cache::tags($tags)->remember($key, self::EXP_MONTH, function() use ($makeId) {
            $items = ModelLang::select([
                    'auto_model.id AS model_id',
                    'auto_model_lang.title AS model_title',
                    'auto_model.slug AS model_slug',
                    'auto_model.image AS image',
                    DB::raw("(
                        SELECT COUNT(*) FROM auto_model_year AS y
                        WHERE y.model_id = auto_model.id AND y.is_active
                    ) AS count_years"),
                    DB::raw("(
                        SELECT COUNT(*) FROM auto_trim_wheel AS tw
                        LEFT JOIN auto_trim AS t ON tw.trim_id = t.id
                        LEFT JOIN auto_model_year AS y ON t.model_year_id = y.id
                        WHERE y.model_id = auto_model.id AND 
                              y.is_active AND 
                              t.is_active AND 
                              t.market_id = " . Market::EUDM . "
                    ) AS count_wheel"),
                    DB::raw("(
                        SELECT MAX(year) FROM auto_model_year AS y
                        WHERE y.model_id = auto_model.id AND y.is_active
                    ) AS last_year"),
                    DB::raw("(
                        SELECT COUNT(*) FROM auto_trim_wheel AS tw
                        LEFT JOIN auto_trim AS t ON tw.trim_id = t.id
                        LEFT JOIN auto_model_year AS y ON t.model_year_id = y.id
                        WHERE y.model_id = auto_model.id AND 
                              y.is_active AND 
                              t.is_active AND 
                              y.year = last_year AND 
                              t.market_id = " . Market::EUDM . "
                    ) AS last_year_count_wheel"),
                ])
                ->translation()
                ->where('auto_model.make_id', $makeId)
                ->where('auto_model.is_active', 1)
                ->with(['model'])
                ->get();
                
            $data = [];
            foreach ($items as $item) {
                $data[] = [
                    'id' => $item->model_id,
                    'slug' => $item->model_slug,
                    'title' => $item->model_title,
                    'image' => $item->model->getThumb('image', 150, 100, 'resize'),
                    'count_years' => $item->count_years,
                    'count_wheel' => $item->count_wheel,
                    'last_year' => $item->last_year,
                    'last_year_count_wheel' => $item->last_year_count_wheel,
                ];
            }
            
            return $data;
        });        
    } 
    
    /**
     * List model with most wheels
     * 
     * @param in $makeId
     * @return array|null
     */
    public function getItemWithMostWheelsByMakeId(int $makeId):? array
    {
        $key = $this->tag . 'getItemWithMostWheelsByMakeId' . $makeId . l();
        $tags = [
            $this->tag,
            (new Make)->tag,
            (new ModelYear)->tag,
        ];
        
        return Cache::tags($tags)->remember($key, self::EXP_MONTH, function() use ($makeId) {
            $item = ModelLang::select([
                    'auto_model.id AS model_id',
                    'auto_model_lang.title AS model_title',
                    DB::raw("(
                        SELECT COUNT(*) FROM auto_trim_wheel AS tw
                        LEFT JOIN auto_trim AS t ON tw.trim_id = t.id
                        LEFT JOIN auto_model_year AS y ON t.model_year_id = y.id
                        WHERE y.model_id = auto_model.id AND 
                              y.is_active AND 
                              t.is_active AND 
                              t.market_id = " . Market::EUDM . "
                    ) AS count_wheels"),
                ])
                ->translation()
                ->where('auto_model.make_id', $makeId)
                ->where('auto_model.is_active', 1)
                ->orderBy('count_wheels', 'DESC')
                ->first();
                
            $data = [];
            if (!empty($item)) {
                $data = $item->toArray();
            }
            
            return $data;
        });        
    } 
    
}
