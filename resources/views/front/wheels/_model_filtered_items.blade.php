@if (count($filteredItems))
<ul class="make__vehicle">
    @foreach($filteredItems as $item)
    <li>
        <div class="make__vehicle-image">
            <a title="{!! $make['title'] !!} {!! $model['title'] !!} {{ t('tire_size') }}" href="#">
                <img alt="{!! $make['title'] !!} {!! $model['title'] !!} {{ t('tire_size') }}" src="{{ $item->image }}">
            </a>
        </div>
        <ul>
            <?php
            $powers = [];
            if (!empty($item->power_hp)) {
                $powers[] = "$item->power_hp hp";
            }
            if (!empty($item->power_kw)) {
                $powers[] = "$item->power_kw kw";
            }
            if (!empty($item->power_ps)) {
                $powers[] = "$item->power_ps PS";
            }

            $generationYearTitle = [];
            if (!empty($item->generation_year_from)) {
                $generationYearTitle[] = $item->generation_year_from;
            }
            if (!empty($item->generation_year_to) && $item->generation_year_to != $item->generation_year_from) {
                $generationYearTitle[] = $item->generation_year_to;
            }
            ?>

            <li>{{ t('generation') }}: {!! $item->generation_title !!} [{!! implode(' .. ', $generationYearTitle) !!}] </li>
            @if (count($powers))
            <li>{{ t('power') }}: {!! implode(' | ', $powers) !!} </li>
            @endif
            <li>{{ t('engine') }}: {!! $item->engine_title !!}</li>
        </ul>
    </li>
    @endforeach
</ul>
@endif
