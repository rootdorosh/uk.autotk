<a name="wheelsizes"></a><h2 class="section-name_2">{{ t('wheels_sizes') }}</h2>

<ul class="years_list">
    @foreach(array_keys($rimData) as $r)
        <li class="years_list_item"><a href="#{{ strtolower($r) }}" class="btn years_list_link">{{ $r }}</a></li>
    @endforeach
</ul>
<br>

@foreach($rimData as $r => $items)
    <ul class="make__vehicle">
        <a name="{{ strtolower($r) }}"></a><h3>{{ $r }}</h3>

        @foreach($items as $item)
            <?php $item = (array) $item?>
            @if (empty($item['rear_rim_diameter']))
                @include('front.wheels._wheel', [
                    'prefix_title' => '',
                    'item' => $item,
                    'key' => 'front',
                ])
            @else
                @include('front.wheels._wheel', [
                    'prefix_title' => t('front'),
                    'item' => $item,
                    'key' => 'front',
                ])
                @include('front.wheels._wheel', [
                    'prefix_title' => t('rear'),
                    'item' => $item,
                    'key' => 'rear',
                ])
            @endif
        @endforeach

    </ul>
@endforeach
