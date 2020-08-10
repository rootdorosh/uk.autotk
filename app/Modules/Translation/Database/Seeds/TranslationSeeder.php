<?php

namespace App\Modules\Translation\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Translation\Models\Translation;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            'make' => 'Make',
            'model' => 'Model',
            'year' => 'Year',
            'engine' => 'Engine',
            'region' => 'Region',
            'wheels' => 'Wheels',
            'all.cars' => 'All cars',
            'all.rights.reserved' => 'All Rights Reserved.',
            'select.the.car.make' => 'Select the Car make',
            'car.specs.and.dimensions' => 'Car specs and dimensions',
            'select.a.car' => 'Select a car',
            'select' => 'Select',
            'go' => 'Go',
            'most.visited.models' => 'Most Visited Models',
            'autotk.internacional' => 'AutoTK Internacional',
            'make.models.list' => '[make] models list',
            'make.specs.and.dimensions' => '[make] specs and dimensions',
            'make.wheels' => '[make] wheels',
            'make.model.wheels' => '[make] [model] wheels',
            'count_years.models.by.year' => '[count_years] models by year',
            'count_wheel.wheel.sizes' => '[count_wheel] wheel sizes',
            'the.latest.year.is.year.with.count_wheels.wheel.sets' => 'The latest year is [year] with [count_wheels] wheel sets',
            'rim_specs' => 'Rim Specs',
            'rim_size' => 'Rim Size',
            'bolt_pattern' => 'Bolt pattern',
            'thread_size' => 'Thread Size',
            'wheel_fasteners' => 'Wheel Fasteners',
            'lug_nut_torque' => 'Lug Nut Torque',
            'rim_width' => 'Rim Width',
            'wheel_offset' => 'Wheel Offset',
            'backspace' => 'Backspace',
            'tyre_specs' => 'Tyre Specs',
            'sidewall_height' => 'Sidewall Height',
            'load_index' => 'Load Index',
            'speed_rating' => 'Speed Rating',
            'tyre_pressure' => 'Tyre Pressure',
            'wheel_diameter' => 'Wheel Diameter',
            'circumference' => 'Circumference',
            'revs_km' => 'Revs/km',
            'wheel_to_tyre_ratio' => 'Wheel to Tyre Ratio',
            'center_bore' => 'Center Bore',
            'front' => 'Front',
            'rear' => 'Rear',
            'kg' => 'kg',
            'km_h' => 'km/h',
            'psi' => 'PSI',
            'bar' => 'bar',
            'select_the_year' => 'Select the Year',
            'generation' => 'Generation',
            'power' => 'Power',
            'tire_size' => 'tire size',
            'wheels_sizes' => 'Wheels Sizes',
            'negative' => 'negative',
            'positive' => 'positive',
            'zero' => 'zero',
            'lug_bolts' => 'Lug bolts',
            'lug_nuts' => 'Lug nuts',
            'global' => 'Global',
            '' => '',
            '' => '',
        ];

        foreach ($items as $slug => $value) {

            if (empty($value)) {
                continue;
            }

            if (Translation::where('slug', '=', $slug)->first() === null) {
                $attrs = compact('slug');
                foreach (config('translatable.locales') as $locale) {
                    $attrs[$locale]['value'] = $value;
                }

                preg_match_all('/(\[(.*?)\])/', $value, $matches);
                if (!empty($matches[2])) {
                    $attrs['params'] = $matches[2];
                }

                $translation = Translation::create($attrs);
                echo "\t Add translation: $translation->slug \n";
            }
        }
    }
}
