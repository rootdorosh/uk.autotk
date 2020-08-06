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
 * Class TrimFetchService
 */
class TrimFetchService extends FetchService
{
    /**
     * @param int $modelId
     * @param int $year
     * @param int $marketId
     * @param int $engineId
     * @return array
     */
    public function getItemsByModelIdAndYearAndMarketIdAndEngineIdFromTrim(int $modelId, int $year, int $marketId, int $engineId): array
    {
        $key = $this->tag . __FUNCTION__ . $modelId . '_' . $year . '_' . $marketId . '_' . $engineId;
        $tags = [
            (new ModelYear)->tag,
            (new Generation)->tag,
            (new Trim)->tag,
            (new Engine)->tag,
        ];

        return Cache::tags($tags)->remember($key, self::EXP_MONTH, function() use ($modelId, $year, $marketId, $engineId) {
            $sql = "SELECT
                        t.power_ps AS power_ps,
                        t.power_kw AS power_kw,
                        t.power_hp AS power_hp,
                        e.title AS engine_title,
                        gl.title AS generation_title,
                        g.year_from AS generation_year_from,
                        g.year_to AS generation_year_to,
                        y.image AS image
                    FROM auto_trim AS t
                    LEFT JOIN auto_model_year AS y ON t.model_year_id = y.id
                    LEFT JOIN auto_generation AS g ON t.generation_id = g.id
                    LEFT JOIN auto_generation_lang AS gl ON g.id = gl.generation_id AND gl.locale = '" . l() . "'
                    LEFT JOIN auto_market AS m ON t.market_id = m.id
                    LEFT JOIN auto_engine AS e ON t.engine_id = e.id
                    WHERE t.is_active AND
                          g.is_active AND
                          y.is_active AND
                          e.id = $engineId AND
                          m.id = $marketId AND
                          y.model_id = $modelId AND
                          y.year = $year
            ";

            $rows = DB::select($sql);
            foreach ($rows as & $row) {
                if (!empty($row->image)) {
                    $row->image = ModelYear::thumb($row->image, 150, 100, 'resize');
                }
            }

            return $rows;
        });
    }

}
