<?php

namespace App\Modules\Auto\Services\Fetch;

use App\Base\FetchService;
use App\Modules\Auto\Models\ModelYear;
use App\Modules\Auto\Models\Trim;
use App\Modules\Auto\Models\Wheel;
use Cache;
use DB;

/**
 * Class TrimWheelFetchService
 */
class TrimWheelFetchService extends FetchService
{

    /**
     * @param int $modelId
     * @return array
     */
    public function getGroupByRimDiameterByModelId(int $modelId): array
    {
        $key = $this->tag . 'getGroupByRimDiameterByModelId' . $modelId . '_' . l();
        $tags = [
            $this->tag,
            (new ModelYear)->getTag(),
            (new Wheel)->getTag(),
            (new Trim)->getTag(),
        ];

        return Cache::tags($tags)->remember($key, self::EXP_MONTH, function () use ($modelId) {
            $sql = "SELECT
                        front.aspect_ratio AS front_aspect_ratio,
                        front.construction AS front_construction,
                        front.rim_diameter AS front_rim_diameter,
                        front.rim_width AS front_rim_width,
                        front.offset AS front_offset,
                        front.tire_width AS front_tire_width,
                        front_si.code AS front_speed_index,
                        front_si.kmh AS front_speed_index_kmh,
                        front_li.index AS front_load_index,
                        front_li.kilograms AS front_load_index_kilograms,
                        rear.aspect_ratio AS rear_aspect_ratio,
                        rear.construction AS rear_construction,
                        rear.rim_diameter AS rear_rim_diameter,
                        rear.rim_width AS rear_rim_width,
                        rear.offset AS rear_offset,
                        rear.tire_width AS rear_tire_width,
                        rear_si.code AS rear_speed_index,
                        rear_si.kmh AS rear_speed_index_kmh,
                        rear_li.index AS rear_load_index,
                        rear_li.kilograms AS rear_load_index_kilograms,
                        bp.pcd AS bolt_pattern_pcd,
                        bp.stud AS bolt_pattern_stud,
                        t.center_bore AS center_bore,
                        t.wheel_fasteners AS wheel_fasteners,
                        t.torque AS torque,
                        ts.title AS thread_size,
                        rw.front_pressure AS front_pressure
                    FROM auto_trim_wheel AS rw
                    LEFT JOIN auto_trim AS t ON rw.trim_id = t.id
                    LEFT JOIN auto_wheel AS front ON rw.front_id = front.id
                    LEFT JOIN auto_wheel AS rear ON rw.rear_id = rear.id
                    LEFT JOIN tire_load_index AS front_li ON front.load_index_id = front_li.id
                    LEFT JOIN tire_load_index AS rear_li ON rear.load_index_id = rear_li.id
                    LEFT JOIN tire_speed_index AS front_si ON front.speed_index_id = front_si.id
                    LEFT JOIN tire_speed_index AS rear_si ON rear.speed_index_id = rear_si.id
                    LEFT JOIN auto_model_year AS y ON t.model_year_id = y.id
                    LEFT JOIN auto_thread_size AS ts ON t.thread_size_id = ts.id
                    LEFT JOIN auto_bolt_pattern AS bp ON y.bolt_pattern_id = bp.id
                    WHERE t.is_active AND y.is_active AND y.model_id = $modelId
                    ORDER BY front.rim_diameter
            ";

            $rows = DB::select($sql);
            $data = [];
            foreach ($rows as $row) {
                $data[$row->front_construction . $row->front_rim_diameter][] = $row;
            }
            return $data;
        });
    }
}
