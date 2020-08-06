<?php

namespace App\Modules\Auto\Services\Fetch;

use App\Modules\Auto\Models\Engine;
use App\Modules\Auto\Models\Generation;
use App\Modules\Auto\Models\Make;
use App\Modules\Auto\Models\Model;
use App\Modules\Auto\Models\ModelYear;
use App\Modules\Auto\Models\Market;
use App\Base\FetchService;
use App\Modules\Auto\Models\Trim;
use Cache;
use DB;

/**
 * Class EngineFetchService
 */
class EngineFetchService extends FetchService
{
    /**
     * @param int $modelId
     * @param int $year
     * @param int $marketId
     * @return array
     */
    public function getItemsByModelIdAndYearAndMarketIdFromTrim(int $modelId, int $year, int $marketId): array
    {
        $key = $this->tag . __FUNCTION__ . $modelId . '_' . $year . '_' . $marketId;
        $tags = [
            (new ModelYear)->tag,
            (new Generation)->tag,
            (new Trim)->tag,
            (new Engine)->tag,
        ];

        return Cache::tags($tags)->remember($key, self::EXP_MONTH, function() use ($modelId, $year, $marketId) {
            $sql = "SELECT
                        e.id,
                        e.title AS title
                    FROM auto_trim AS t
                    LEFT JOIN auto_model_year AS y ON t.model_year_id = y.id
                    LEFT JOIN auto_generation AS g ON t.generation_id = g.id
                    LEFT JOIN auto_market AS m ON t.market_id = m.id
                    LEFT JOIN auto_engine AS e ON t.engine_id = e.id
                    WHERE t.is_active AND
                          g.is_active AND
                          y.is_active AND
                          m.id = $marketId AND
                          y.model_id = $modelId AND
                          y.year = $year
                    GROUP BY t.engine_id
                    ORDER BY e.title DESC
            ";

            $rows = DB::select($sql);
            $data = [];
            foreach ($rows as $row) {
                $data[$row->id] = $row->title;
            }

            return $data;
        });
    }

}
