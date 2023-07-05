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
        <!--
		<h2 class="section-name_2">Toyota Camry specs</h2>

        <a href="https://autotk.com/toyota/camry/" title="Toyota Camry specs">
            <img src="./Toyota Camry Bolt Pattern, Wheel Size, Lug Pattern and Rim Specs_files/Toyota-Camry-2019(1).jpg">
        </a>

        <table class="right-block__specs-list">
            <tbody>
            <tr>
                <td>
                    <a title="Toyota Camry parts" class="parts" href="https://www.amazon.com/s/ref=as_li_ss_tl?k=Toyota+Camry+Parts&amp;i=automotive&amp;imprToken=ZqtqVclR1UWmAJs5eIMqXw&amp;slotNum=1&amp;ref=as_li_ss_tl&amp;linkCode=ll2&amp;tag=autotk-sidebar-20&amp;linkId=9794584276b108832a7c0fe92e364e8e&amp;language=en_US" data-amzn-asin="automotive">Camry Parts</a>
                </td>
            </tr>
            </tbody>
        </table>
		-->

    </section>						<div class="banner-ver">

    </div>

</div>
<script>
    window.currentUrl = '{!! request()->url()!!}';
</script>
@endsection
