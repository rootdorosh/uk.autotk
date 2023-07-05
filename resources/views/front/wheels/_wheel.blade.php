<li>
    <h4>{{ $prefix_title }} {{ $item[$key . '_tire_width'] }}/{{ $item[$key . '_aspect_ratio'] }}{{ $item[$key . '_construction'] }}{{ $item[$key . '_rim_diameter'] }} {{ $item[$key . '_load_index'] }}{{ $item[$key . '_speed_index'] }} on {{ $item[$key . '_rim_diameter'] }}x{{ $item[$key . '_rim_width'] }}J {{ $item[$key . '_offset'] }}</h4>
    <div class="make__vehicle-image">
    </div>
    <div style="float:left; margin:10px;"><b>{{ t('rim_specs') }}</b>
        <ul>
            <li><a style="border-bottom: 1px dashed;" href="#rimsize">{{ t('rim_size') }}:</a> {{ $item[$key . '_rim_diameter'] }}x{{ $item[$key . '_rim_width'] }}J ET{{ $item[$key . '_offset'] }}</li>

            @if (!empty($item['bolt_pattern_pcd']) && !empty($item['bolt_pattern_stud']))
            <?php
                $ddPcd = round($item['bolt_pattern_pcd'] / 25.4, 2);
                $ddPcd = rtrim($ddPcd, '0');
                $ddPcd = rtrim($ddPcd, '.0');

                $bpPcd = $item['bolt_pattern_pcd'];
                if (\Illuminate\Support\Str::afterLast($item['bolt_pattern_pcd'], '.') == '0') {
                    $bpPcd = str_replace('.0', '', $bpPcd);
                }
            ?>
            <li><a style="border-bottom: 1px dashed;" href="#boltpattern">{{ t('bolt_pattern') }}:</a> {{ $item['bolt_pattern_stud'] }}x{{ $bpPcd }} / {{ $item['bolt_pattern_stud'] }}x{{ $ddPcd }}"</li>
            @endif

            @if (!empty($item['center_bore']))
            <li><a style="border-bottom: 1px dashed;" href="#centerbore">{{ t('center_bore') }}:</a> {{ $item['center_bore'] }} mm</li>
            @endif

            @if (!empty($item['thread_size']))
            <li><a style="border-bottom: 1px dashed;" href="#threadsize">{{ t('thread_size') }}:</a> {{ $item['thread_size'] }}</li>
            @endif

            <?php
                $mapTrans = [
                    'Lug bolts' => 'lug_bolts',
                    'Lug nuts' => 'lug_nuts',
                ];
                $val = trim($item['wheel_fasteners']);
                $wheelFasteners = $val !== '' && isset($mapTrans[$val]) ? t($mapTrans[$val]) : '';
            ?>

            @if ($wheelFasteners !== '')
            <li><a style="border-bottom: 1px dashed;" href="#wheelfasteners">{{ t('wheel_fasteners') }}:</a> {{ $wheelFasteners }}</li>
            @endif

            @if (!empty($item['torque']))
            <li><a style="border-bottom: 1px dashed;" href="#lugnuttorque">{{ t('lug_nut_torque') }}:</a> {{ $item['torque'] }} Nm</li>
            @endif

            <li><a style="border-bottom: 1px dashed;" href="#rimwidth">{{ t('rim_width') }}:</a> {{ $item[$key . '_rim_width'] }}" ({{ $item[$key . '_rim_width'] * 25.4 }} mm)</li>

            <?php ?>

            <?php
                $offsetTitle = '';

                if ($item[$key . '_offset'] == '0') {
                    $offsetTitle = t('zero');
                } elseif ($item[$key . '_offset'] > 0) {
                    $offsetTitle = t('positive');
                } elseif ($item[$key . '_offset'] > 0) {
                    $offsetTitle = t('negative');
                }
            ?>

            @if ($offsetTitle !== '')
            <li><a style="border-bottom: 1px dashed;" href="#wheeloffset">{{ t('wheel_offset') }}:</a> {{ $item[$key . '_offset'] }} mm ({{ $offsetTitle }})</li>
            @endif

            <?php
                $ddBackspace = round(($item[$key . '_rim_width'] + 1)/2 + ($item[$key . '_offset']/25.4), 2);
            ?>
            <li><a style="border-bottom: 1px dashed;" href="#backspace">{{ t('backspace') }}:</a> {{ round($ddBackspace * 25.4) }} mm / {{ $ddBackspace }}"</li>


        </ul>
    </div>
    <div style="float:left; margin:10px 10px 10px 50px;"><b>{{ t('tyre_specs') }}</b>
        <ul>
            <li><a style="border-bottom: 1px dashed;" href="#tyresize">{{ t('tyre_specs') }}:</a> {{ $item[$key . '_tire_width'] }}/{{ $item[$key . '_aspect_ratio'] }}{{ $item[$key . '_construction'] }}{{ $item[$key . '_rim_diameter'] }} {{ $item[$key . '_load_index'] }}{{ $item[$key . '_speed_index'] }}</li>

            <li><a style="border-bottom: 1px dashed;" href="#sidewallheight">{{ t('sidewall_height') }}:</a> {{ $item[$key . '_aspect_ratio'] }}% ({{ round(($item[$key . '_tire_width'] * $item[$key . '_aspect_ratio']) / 100) }} mm)</li>

            @if (!empty($item[$key . '_load_index']))
            <li><a style="border-bottom: 1px dashed;" href="#loadindex">{{ t('load_index') }}:</a> {{ $item[$key . '_load_index'] }} @if (!empty($item[$key . '_load_index_kilograms']))({{ $item[$key . '_load_index_kilograms'] }} kg) @endif</li>
            @endif

            @if (!empty($item[$key . '_speed_index']))
            <li><a style="border-bottom: 1px dashed;" href="#speedrating">{{ t('speed_rating') }}:</a> {{ $item[$key . '_speed_index'] }} @if($item[$key . '_speed_index_kmh']) ({{ $item[$key . '_speed_index_kmh'] }} {{ t('km_h') }})@endif</li>
            @endif

            @if (!empty($item['front_pressure']))
            <li><a style="border-bottom: 1px dashed;" href="#tyrepressure">{{ t('tyre_pressure') }}:</a> {{ $item['front_pressure'] }} {{ t('bar') }} / {{ round($item['front_pressure'] * 14.5, 1)  }} {{ t('psi') }}</li>
            @endif

            @if (!empty($item[$key . '_aspect_ratio']))
                <?php $wheelDiameter = $item[$key . '_rim_diameter'] * 25.4 + 2 * (($item[$key . '_tire_width'] * $item[$key . '_aspect_ratio']) / 100) ?>
                <li><a style="border-bottom: 1px dashed;" href="#wheeldiameter">{{ t('wheel_diameter') }}:</a> {{ round($wheelDiameter) }} mm / {{ round($wheelDiameter / 25.4, 1) }}"</li>

                <?php $circumference = $wheelDiameter * pi()?>
                <li><a style="border-bottom: 1px dashed;" href="#circumference">{{ t('circumference') }}:</a> {{ round($circumference) }} mm</li>

                @if ($circumference > 0)
                <li><a style="border-bottom: 1px dashed;" href="#revskm">{{ t('revs_km') }}:</a> {{ round((1000 / $circumference) * 1000) }}</li>
                @endif
            @endif

            @if (!empty($item[$key . '_rim_width']) && !empty($item[$key . '_tire_width']))
            <li><a style="border-bottom: 1px dashed;" href="#wheeltotyreratio">{{ t('wheel_to_tyre_ratio') }}:</a> {{ round($item[$key . '_rim_width'] * 25.4 / $item[$key . '_tire_width'] * 100, 2) }}%</li>
            @endif
        </ul>
    </div>
</li><br>
