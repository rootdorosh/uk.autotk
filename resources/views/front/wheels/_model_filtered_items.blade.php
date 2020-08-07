@if ($filteredItem)
<ul class="make__vehicle">
    <li>
        <div class="make__vehicle-image">
            <a title="{!! $make['title'] !!} {!! $model['title'] !!} {{ t('tire_size') }}" href="#">
                <img alt="{!! $make['title'] !!} {!! $model['title'] !!} {{ t('tire_size') }}" src="{{ $filteredItem->image }}">
            </a>
        </div>
        <ul>
            <?php
            $powers = [];
            if (!empty($filteredItem->power_hp)) {
                $powers[] = "$filteredItem->power_hp hp";
            }
            if (!empty($filteredItem->power_kw)) {
                $powers[] = "$filteredItem->power_kw kw";
            }
            if (!empty($filteredItem->power_ps)) {
                $powers[] = "$filteredItem->power_ps PS";
            }

            $generationYearTitle = [];
            if (!empty($filteredItem->generation_year_from)) {
                $generationYearTitle[] = $filteredItem->generation_year_from;
            }
            if (!empty($filteredItem->generation_year_to) && $filteredItem->generation_year_to != $filteredItem->generation_year_from) {
                $generationYearTitle[] = $filteredItem->generation_year_to;
            }
            ?>

            <li>{{ t('generation') }}: {!! $filteredItem->generation_title !!} [{!! implode(' .. ', $generationYearTitle) !!}] </li>
            @if (count($powers))
            <li>{{ t('power') }}: {!! implode(' | ', $powers) !!} </li>
            @endif
            <li>{{ t('engine') }}: {!! $filteredItem->trim_title !!}</li>
        </ul>
    </li>
</ul>
@endif
