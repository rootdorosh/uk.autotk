<?php

namespace App\Modules\Auto\Services\Fetch;

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
 * Class MarketFetchService
 */
class MarketFetchService extends FetchService
{
    public function getItemsByModelIdAndYearFromTrim(int $modelId, int $year): array
    {
        $key = $this->tag . __FUNCTION__ . $modelId . '_' . $year . l();
        $tags = [
            (new ModelYear)->tag,
            (new Market)->tag,
            (new Generation)->tag,
            (new Trim)->tag,
        ];

        return Cache::tags($tags)->remember($key, self::EXP_MONTH, function() use ($modelId, $year) {
            $sql = "SELECT
                        m.id,
                        ml.title AS title
                    FROM auto_trim AS t
                    LEFT JOIN auto_model_year AS y ON t.model_year_id = y.id
                    LEFT JOIN auto_generation AS g ON t.generation_id = g.id
                    LEFT JOIN auto_market AS m ON t.market_id = m.id
                    LEFT JOIN auto_market_lang AS ml ON ml.market_id = m.id AND ml.locale = '" . l() . "'
                    LEFT JOIN auto_engine AS e ON t.engine_id = e.id
                    WHERE t.is_active AND
                          g.is_active AND
                          m.is_active AND
                          y.is_active AND
                          y.model_id = $modelId AND
                          y.year = $year
                    GROUP BY t.market_id
                    ORDER BY y.year DESC
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
