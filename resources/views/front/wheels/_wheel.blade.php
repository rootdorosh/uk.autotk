<li>
    <!--  Перечисляем все размеры, привязанные к данной машине -->

    <!--  205 - tire_width
    65 - aspect_ratio
    R - construction
    16 - rim_diameter
    95 - load_index
    H - speed_rating
    16 - rim_diameter
    6,5 - rim_width
    ET40 - offset
    -->

    <h4>{{ $prefix_title }} {{ $item[$key . '_tire_width'] }}/{{ $item[$key . '_aspect_ratio'] }}{{ $item[$key . '_construction'] }}{{ $item[$key . '_rim_diameter'] }} {{ $item[$key . '_load_index'] }}{{ $item[$key . '_speed_index'] }} on {{ $item[$key . '_rim_diameter'] }}x{{ $item[$key . '_rim_width'] }}J {{ $item[$key . '_offset'] }}</h4>
    <div class="make__vehicle-image">
    </div>
    <div style="float:left; margin:10px;"><b>{{ t('rim_specs') }}</b>
        <ul>
            <!-- Ставим якоря на faq который идет ниже под таблицами параметров -->
            <!-- 16 - rim_diameter / 6,5 - rim_width / ET40 - offset -->
            <li><a style="border-bottom: 1px dashed;" href="#rimsize">{{ t('rim_size') }}:</a> {{ $item[$key . '_rim_diameter'] }}x{{ $item[$key . '_rim_width'] }}J ET{{ $item[$key . '_offset'] }}</li>

            <!-- 5x114.3 - bolt pattern из таблицы auto_bolt_pattern в формате: stud x pcd.
            Если pcd - целое число, то выводим как целое типа 120 а не 120.0 / дальше через слэш выводим pcd в дюймах по формуле pcd / 25.4 и выводим флоат число с максимум 2 цифры после точки -->
            @if (!empty($item['bolt_pattern_pcd']) && !empty($item['bolt_pattern_stud']))
            <?php
                $ddPcd = round($item['bolt_pattern_pcd'] / 25.4, 2);
                $ddPcd = rtrim($ddPcd, '0');
                $ddPcd = rtrim($ddPcd, '.0');
            ?>
            <li><a style="border-bottom: 1px dashed;" href="#boltpattern">{{ t('bolt_pattern') }}:</a> {{ $item['bolt_pattern_stud'] }}x{{ rtrim($item['bolt_pattern_pcd'], '.0') }} / {{ $item['bolt_pattern_stud'] }}x{{ $ddPcd }}"</li>
            @endif

            <!-- 60.1 mm - center_bore из auto_trim -->
            @if (!empty($item['center_bore']))
            <li><a style="border-bottom: 1px dashed;" href="#centerbore">{{ t('center_bore') }}:</a> {{ $item['center_bore'] }} mm</li>
            @endif

            <!-- M12 x 1.5 - thread_size_id из auto_trim -->
            @if (!empty($item['thread_size']))
            <li><a style="border-bottom: 1px dashed;" href="#threadsize">{{ t('thread_size') }}:</a> {{ $item['thread_size'] }}</li>
            @endif

            <!-- Lug nuts - wheel_fasteners из auto_trim -->

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

            <!-- 103 Nm - torque из auto_trim -->
            @if (!empty($item['torque']))
            <li><a style="border-bottom: 1px dashed;" href="#lugnuttorque">{{ t('lug_nut_torque') }}:</a> {{ $item['torque'] }} Nm</li>
            @endif

            <!-- 6.5" - rim_width из auto_wheel (в скобках выводим значение в мм, умножив rim_width * 25.4 -->
            <li><a style="border-bottom: 1px dashed;" href="#rimwidth">{{ t('rim_width') }}:</a> {{ $item[$key . '_rim_width'] }}" ({{ $item[$key . '_rim_width'] * 25.4 }} mm)</li>

            <!-- 40 mm - offset из auto_wheel. В скобках выводим слово positive если значение более нуля, negative если меньше нуля и zero если значение ноль -->
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

            <!-- Формула backspace
            Backspace = (rim_width + 1)/2 + (offset/25.4)
            Полученное число - это в дюймах, потом его умножаем на 2,54 и будут мм
            -->
            <?php
                $ddBackspace = round(($item[$key . '_rim_width'] + 1)/2 + ($item[$key . '_offset']/25.4), 2);
            ?>
            <li><a style="border-bottom: 1px dashed;" href="#backspace">{{ t('backspace') }}:</a> {{ round($ddBackspace * 25.4) }} mm / {{ $ddBackspace }}"</li>


        </ul>
    </div>
    <div style="float:left; margin:10px 10px 10px 50px;"><b>{{ t('tyre_specs') }}</b>
        <ul>
            <!-- 205 - tire_width из auto_wheel / 65 - aspect_ratio / R16 - rim_diameter /  95H - load_index и speed_rating -->
            <li><a style="border-bottom: 1px dashed;" href="#tyresize">{{ t('tyre_specs') }}:</a> {{ $item[$key . '_tire_width'] }}/{{ $item[$key . '_aspect_ratio'] }}{{ $item[$key . '_construction'] }}{{ $item[$key . '_rim_diameter'] }} {{ $item[$key . '_load_index'] }}{{ $item[$key . '_speed_index'] }}</li>

            <!-- Значение 113мм в скобках, формула: tire_width * sidewall_height / 100 -->
            <li><a style="border-bottom: 1px dashed;" href="#sidewallheight">{{ t('sidewall_height') }}:</a> {{ $item[$key . '_aspect_ratio'] }}% ({{ round(($item[$key . '_tire_width'] * $item[$key . '_aspect_ratio']) / 100) }} mm)</li>

            <!-- 95 - load_index из auto_wheel.
            Переделай структуру, вынеси в отдельную таблицу, возьми эту таблицу и данные с бд autof_db - таблица tire_load_index. И тогда 95 - это поле index, 690 - поле kilograms  -->
            @if (!empty($item[$key . '_load_index']))
            <li><a style="border-bottom: 1px dashed;" href="#loadindex">{{ t('load_index') }}:</a> {{ $item[$key . '_load_index'] }} @if (!empty($item[$key . '_load_index_kilograms']))({{ $item[$key . '_load_index_kilograms'] }} kg) @endif</li>
            @endif

            <!-- То же что и для load index - возьми структуру из autof_db, таблица tire_speed_index. Только там нет значений, я занесу руками. H - поле code, 210 - поле kmh  -->
            @if (!empty($item[$key . '_speed_index']))
            <li><a style="border-bottom: 1px dashed;" href="#speedrating">{{ t('speed_rating') }}:</a> {{ $item[$key . '_speed_index'] }} @if($item[$key . '_speed_index_kmh']) ({{ $item[$key . '_speed_index_kmh'] }} {{ t('km_h') }})@endif</li>
            @endif

            <!-- 2.4 - front_pressure из auto_trim_wheel. Чтобы получить psi, умножаем bar на 14.5 -->
            @if (!empty($item['front_pressure']))
            <li><a style="border-bottom: 1px dashed;" href="#tyrepressure">{{ t('tyre_pressure') }}:</a> {{ $item['front_pressure'] }} {{ t('bar') }} / {{ round($item['front_pressure'] * 14.5, 1)  }} {{ t('psi') }}</li>
            @endif

            <!-- Wheel Diameter = rim_diameter * 25.4 + 2 * sidewall_height
            Например для 205/65R16: 16*25.4 + 2*113 = 673mm / Потом это число делим на 25.4 и получаем дюймы
            -->
            @if (!empty($item[$key . '_aspect_ratio']))
                <?php $wheelDiameter = $item[$key . '_rim_diameter'] * 25.4 + 2 * (($item[$key . '_tire_width'] * $item[$key . '_aspect_ratio']) / 100) ?>
                <li><a style="border-bottom: 1px dashed;" href="#wheeldiameter">{{ t('wheel_diameter') }}:</a> {{ round($wheelDiameter) }} mm / {{ round($wheelDiameter / 25.4, 1) }}"</li>

                <!-- Формула: Wheel Diameter * число Пи -->
                <?php $circumference = $wheelDiameter * pi()?>
                <li><a style="border-bottom: 1px dashed;" href="#circumference">{{ t('circumference') }}:</a> {{ round($circumference) }} mm</li>

                <!-- Формула:  1000 / Circumference -->
                @if ($circumference > 0)
                <li><a style="border-bottom: 1px dashed;" href="#revskm">{{ t('revs_km') }}:</a> {{ round((1000 / $circumference) * 1000) }}</li>
                @endif
            @endif


            <!-- Формула:  rim_width * 25.4 / tire_width * 100 -->
            @if (!empty($item[$key . '_rim_width']) && !empty($item[$key . '_tire_width']))
            <li><a style="border-bottom: 1px dashed;" href="#wheeltotyreratio">{{ t('wheel_to_tyre_ratio') }}:</a> {{ round($item[$key . '_rim_width'] * 25.4 / $item[$key . '_tire_width'] * 100, 2) }}%</li>
            @endif
        </ul>
    </div>
</li><br>
