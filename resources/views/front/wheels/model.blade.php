@extends('front.layouts.main')

@section('content')
<div class="l-col1" style="height: auto !important;">
    <h1 class="section-name_2">{{ $seo->h1 }}</h1>


    <section class="times clearfix">
        <div class="google_links f_left p_rel" style="height: auto !important;"></div>
        <div class="text_size">
            {!! $seo->header_text !!}
        </div>
    </section>

    @if (count($years))
    <div class="options">
        <h2>{{ t('select_the_year') }}</h2>
        <div class="options__block">
            <div class="options__item">
                <strong>{{ t('year') }}</strong>
                <select id="wheels-model-year">
                @foreach($years as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
                </select>
            </div>
            <div class="options__item">
                <strong>{{ t('region') }}</strong>
                <select id="wheels-market">
                @foreach($markets as $k => $v)
                    <option value="{{ $k }}" {!! $k===$selectedMarketId ? 'selected="selected"':'' !!}>{{ $v }}</option>
                @endforeach
                </select>
            </div>
            <div class="options__item">
                <strong>{{ t('engine') }}</strong>
                <select id="wheels-trim">
                    @foreach($trims as $k => $v)
                        <option value="{{ $k }}" {!! $k===$selectedTrimId ? 'selected="selected"':'' !!}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
            <!-- <button style="display: none;" type="submit" class="btn btn_options" id="btn_submit_filter">GO</button>-->
        </div>
    </div>
    <br>
    @if ($filteredItem)
    <section class="make">
        <h2 class="js-filter-result-title section-name_2" data-title="{!! $make['title'] !!} {!! $model['title'] !!}">{!! $filteredTitle !!}</h2>
        <div id="wheel-filter-result">
        @include('front.wheels._model_filtered_items')
        </div>
    </section>
    @endif
    @endif


    @if (!empty($rimData))
    <section class="make" id="wrap-rim">
        @include('front.wheels._model_rims')
    </section>
    @endif


    <div class="banner-ver">

    </div>




</div>
<div class="l-col2">

	<br>
    <section class="right-block">
     
    </section>						<div class="banner-ver">

    </div>

</div>
<script>
    window.currentUrl = '{!! request()->url()!!}';
</script>
@endsection
