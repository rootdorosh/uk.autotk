<?php

namespace App\Modules\Auto\Services\Fetch;

use App\Modules\Auto\Models\Generation;
use App\Modules\Auto\Models\Market;
use App\Modules\Auto\Models\Trim;
use Illuminate\Support\Collection;
use App\Modules\Auto\Models\Make;
use App\Modules\Auto\Models\Model;
use App\Modules\Auto\Models\ModelYear;
use App\Modules\Auto\Models\Lang\ModelLang;
use App\Modules\Core\Models\Domain;
use App\Base\FetchService;
use Cache;
use FrontPage;
use DB;
use phpDocumentor\Reflection\DocBlock\Tags\Generic;

/**
 * Class ModelYearFetchService
 */
class ModelYearFetchService extends FetchService
{
    /**
     * @return array
     */
    public function getListYears(): array
    {
        $key = $this->tag . '_getListYears_' . l();
        $tags = [
            $this->tag,
            (new Make)->tag,
            (new Model)->tag,
        ];

        return Cache::tags($tags)->remember($key, self::EXP_MONTH, function() {
            $items = ModelYear::select([
                    DB::raw('DISTINCT auto_model_year.year AS year'),
                ])
                ->leftJoin('auto_model_lang', 'auto_model_lang.model_id', '=', 'auto_model_year.model_id')
                ->leftJoin('auto_model', 'auto_model.id', '=', 'auto_model_year.model_id')
                ->leftJoin('auto_make', 'auto_make.id', '=', 'auto_model.make_id')
                ->leftJoin('auto_make_lang', 'auto_make_lang.make_id', '=', 'auto_make.id')
                ->where('auto_make_lang.is_translated', 1)
                ->where('auto_make_lang.locale', l())
                ->where('auto_make.is_active', 1)
                ->where('auto_model_lang.is_translated', 1)
                ->where('auto_model_lang.locale', l())
                ->where('auto_model.is_active', 1)
                ->orderBy('year', 'DESC')
                ->get();

            $data = [];
            foreach ($items as $item) {
                $data[$item->year] = $item->year;
            }

            return $data;
        });
    }

    /**
     * @param int $modelId
     * @return array
     */
    public function getItemsByModelIdFromTrim(int $modelId): array
    {
        $key = $this->tag . __FUNCTION__ . $modelId;
        $tags = [
            (new Make)->tag,
            (new Model)->tag,
            (new ModelYear)->tag,
            (new Market)->tag,
            (new Generation)->tag,
            (new Trim)->tag,
        ];

        return Cache::tags($tags)->remember($key, self::EXP_MONTH, function() use ($modelId) {
            $sql = "SELECT
                        DISTINCT y.year AS `year`
                    FROM auto_trim AS t
                    LEFT JOIN auto_model_year AS y ON t.model_year_id = y.id
                    LEFT JOIN auto_generation AS g ON t.generation_id = g.id
                    LEFT JOIN auto_market AS m ON t.market_id = m.id
                    LEFT JOIN auto_engine AS e ON t.engine_id = e.id
                    WHERE t.is_active AND
                          g.is_active AND
                          m.is_active AND
                          y.is_active AND
                          y.model_id = $modelId AND
                          t.market_id IS NOT NULL
                    ORDER BY y.year DESC
            ";

            $rows = DB::select($sql);
            $data = [];
            foreach ($rows as $row) {
                $data[] = $row->year;
            }

            return $data;
        });
    }

    /**
     * @param int $year
     * @return array
     */
    public function getListMakesByYear(int $year): array
    {
        $key = $this->tag . '_getListMakesByYear_' . $year  . l();
        $tags = [
            $this->tag,
            (new Make)->tag,
            (new Model)->tag,
        ];

        return Cache::tags($tags)->remember($key, self::EXP_MONTH, function() use ($year) {
            $items = ModelYear::select([
                    DB::raw('DISTINCT auto_make.id AS make_id'),
                    'auto_make.slug AS make_slug',
                    'auto_make_lang.title AS make_title',
                ])
                ->leftJoin('auto_model_lang', 'auto_model_lang.model_id', '=', 'auto_model_year.model_id')
                ->leftJoin('auto_model', 'auto_model.id', '=', 'auto_model_year.model_id')
                ->leftJoin('auto_make', 'auto_make.id', '=', 'auto_model.make_id')
                ->leftJoin('auto_make_lang', 'auto_make_lang.make_id', '=', 'auto_make.id')
                ->where('auto_make_lang.is_translated', 1)
                ->where('auto_make_lang.locale', l())
                ->where('auto_make.is_active', 1)
                ->where('auto_model_lang.is_translated', 1)
                ->where('auto_model_lang.locale', l())
                ->where('auto_model.is_active', 1)
                ->where('auto_model_year.year', $year)
                ->orderBy('make_title', 'ASC')
                ->get();

            $data = [];
            foreach ($items as $item) {
                $data[] = [
                    'id' => $item->make_id,
                    'slug' => $item->make_slug,
                    'title' => $item->make_title,
                ];
            }

            return $data;
        });
    }

    /**
     * @param int $year
     * @param int $makeId
     * @return array
     */
    public function getListModelsByYearAndMakeId(int $year, int $makeId): array
    {
        $key = $this->tag . 'getListModelsByYearAndMakeId' . $year  . '_' . $makeId . l();
        $tags = [
            $this->tag,
            (new Make)->tag,
            (new Model)->tag,
        ];

        return Cache::tags($tags)->remember($key, self::EXP_MONTH, function() use ($year, $makeId) {
            $items = ModelYear::select([
                    DB::raw('DISTINCT auto_model.id AS model_id'),
                    'auto_model.slug AS model_slug',
                    'auto_model_lang.title AS model_title',
                ])
                ->leftJoin('auto_model_lang', 'auto_model_lang.model_id', '=', 'auto_model_year.model_id')
                ->leftJoin('auto_model', 'auto_model.id', '=', 'auto_model_year.model_id')
                ->leftJoin('auto_make', 'auto_make.id', '=', 'auto_model.make_id')
                ->leftJoin('auto_make_lang', 'auto_make_lang.make_id', '=', 'auto_make.id')
                ->where('auto_make_lang.is_translated', 1)
                ->where('auto_make_lang.locale', l())
                ->where('auto_make.is_active', 1)
                ->where('auto_model_lang.is_translated', 1)
                ->where('auto_model_lang.locale', l())
                ->where('auto_model.is_active', 1)
                ->where('auto_model_year.year', $year)
                ->where('auto_make.id', $makeId)
                ->orderBy('model_title', 'ASC')
                ->get();

            $data = [];
            foreach ($items as $item) {
                $data[] = [
                    'id' => $item->model_id,
                    'slug' => $item->model_slug,
                    'title' => $item->model_title,
                ];
            }

            return $data;
        });
    }

    /**
     * @param int $makeId
     * @return array|null
     */
    public function getItemStartByMakeId(int $makeId):? array
    {
        $key = $this->tag . 'getItemStartByMakeId_' . $makeId . l();
        $tags = [
            $this->tag,
            (new Model)->tag,
            (new ModelYear)->tag,
        ];

        return Cache::tags($tags)->remember($key, self::EXP_MONTH, function() use ($makeId) {
            $item = ModelYear::select([
                    'auto_model.id AS model_id',
                    'auto_model.slug AS model_slug',
                    'auto_model_lang.title AS model_title',
                    'auto_model_year.id AS model_year_id',
                    'auto_model_year.year AS year',
                ])
                ->leftJoin('auto_model_lang', 'auto_model_lang.model_id', '=', 'auto_model_year.model_id')
                ->leftJoin('auto_model', 'auto_model.id', '=', 'auto_model_year.model_id')
                ->where('auto_model_lang.is_translated', 1)
                ->where('auto_model_lang.locale', l())
                ->where('auto_model.is_active', 1)
                ->where('auto_model_year.is_active', 1)
                ->where('auto_model.make_id', $makeId)
                ->orderBy('year', 'ASC')
                ->first();

            $data = [];
            if ($item !== null) {
                $data = $item->toArray();
            }

            return $data;
        });
    }

}
