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

    <!-- Дальше идет серия блоков вопросов и ответов.
    Каждый блок должен быть отдельным полями textarea.
    Вопрос там будет одинаково написан, и для него нужны переменные: марка, модель и год авто.
    А ответ - для каждой такой страницы, для каждого блока будет уникальный.
    Наполнять ответы я хочу массовым импортом, можем сделать импорт файла на 20 колонок (у нас столько полей текста).
    Также для каждого поля должна быть прилеплена отдельная картинка, и она не должна меняться, даже во всех языках должна быть одинаковой.

    То что мы нагенерим - надо будет переводить для каждого языка, а значит надо еще сделать импорт текстов для каждого языка.

    -->

	<?php /*?>
    <section class="make">

        <h2 class="section-name_2">Wheels Specs FAQ</h2>
        <ul class="make__vehicle">
            <li>
                <a name="rimsize"></a>
                <ul>
                    <img alt="Toyota Camry tire size" src="rimsize.jpg" style="padding:10px;float:left;">
                    <h3>What is the rim size of a 2019 Toyota Camry?</h3>

                    <!-- Выводим переменную [rim_sizes] в формате "минимальный диаметр диска - максимальный диаметр на эту машину для этого года, например: "R16-R20". Если вариант диска один, то просто выводим R16. -->
                    Rim Sizes are . You can buy custom wheels for Toyota Camry with the same diameter, offset and rim size as your factory wheels. Or you can go with a set of aftermarket wheels that are bigger, wider and with less offset for a truly custom look. It is almost always possible to replace factory Toyota Camry wheels and run with bigger rim size on it without too much trouble.<br><a style="border-bottom: 1px dashed;" href="#wheelsizes">< Back</a>
                </ul>
            </li>


            <li>
                <a name="boltpattern"></a>

                <ul>
                    <img alt="Toyota Camry tire size" style="float:right;" src="boltpattern.jpg">
                    <h3>What is the bolt pattern on a 2019 Toyota Camry?</h3>

                    <!-- Выводим переменную [bolt_pattern]. Если у модели по годам более одного значения разболтовки, то выводим через запятую		-->
                    Bolt pattern is 5x114.3. Bolt pattern or bolt circle is the diameter of an imaginary circle formed by the centers of the wheel lugs. <br>You can change Bolt Pattern to 5x100, 5x127 and other by using <a href="#">Wheel Adapters</a><br><a style="border-bottom: 1px dashed;" href="#wheelsizes">< Back</a>
                </ul>
            </li>


            <li>
                <a name="centerbore"></a>

                <ul>
                    <img alt="Toyota Camry tire size" src="hubbore.jpg" style="padding:10px;float:left;">
                    <h3>What is the hub bore (center bore) on a 2019 Toyota Camry?</h3>

                    <!-- Выводим значение поля center bore для данной модели по годам. Если значений несколько, то через запятую -->
                    The center bore is 60.1 mm. Starting from 1992 Camry changed its center bore from 54.1 mm to 60.1 mm. You can install rims with different larger holes if you use hub centric rings: 63.4 mm -> 60.1 mm, 64.1 mm -> 60.1 mm, 72.6 mm -> 60.1 mm, 83.1 mm -> 60.1 mm, etc. What size hub centric ring do you need? There are two measurements needed to determine what size hub ring you need:<br> &ndash; The inner diameter or hub diameter of your Toyota Camry (it's 60.1 mm) <br> &ndash; The outer diameter or wheel center bore diameter. <a href="#">Read More</a><br><a style="border-bottom: 1px dashed;" href="#wheelsizes">< Back</a>
                </ul>
            </li>


            <li>
                <a name="threadsize"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>What is the Thread Size on a 2019 Toyota Camry?</h3>
                    <!-- Выводим значение поля thread size для данной модели по годам. Если значений несколько, то через запятую -->
                    Bolt pattern is 5x114.3. Bolt pattern or bolt circle is the diameter of an imaginary circle formed by the centers of the wheel lugs. <br>You can change Bolt Pattern to 5x100, 5x127 and other by using <a href="#">Wheel Adapters</a><br><a style="border-bottom: 1px dashed;" href="#wheelsizes">< Back</a>
                </ul>
            </li>


            <li>
                <a name="wheelfasteners"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>What type of Wheel Fasteners on a 2019 Toyota Camry?</h3>
                    <!-- Выводим значение поля Wheel Fasteners для данной модели по годам. Если значений несколько, то через запятую -->
                    You can change Bolt Pattern to 5x100, 5x127 and other by using <a href="#">Wheel Adapters</a>. Bolt pattern is 5x114.3. Bolt pattern or bolt circle is the diameter of an imaginary circle formed by the centers of the wheel lugs.<br><a style="border-bottom: 1px dashed;" href="#wheelsizes">< Back</a>
                </ul>
            </li>


            <li>
                <a name="lugnuttorque"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>How tight should lug nuts be torqued on a 2019 Toyota Camry?</h3>
                    <!-- Выводим значение поля lug nut torque для данной модели по годам. Если значений несколько, то через запятую -->
                    Based on your studs being 1/2 inch, your wheels being 15 inches in diameter, and your lug nuts being coned you would want to torque your lug nuts to 90-120 ft lbs of torque.
                </ul>
            </li>


            <li>
                <a name="rimwidth"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>What is the Rim Width?</h3>
                    <!-- Выводим значение поля rim width для данной модели по годам. Если значений несколько, то выводим 2 значения - минимальное wheeloffset_min и максимальное wheeloffset_max -->
                    Based on your studs being 1/2 inch, your wheels being 15 inches in diameter, and your lug nuts being coned you would want to torque your lug nuts to 90-120 ft lbs of torque.
                </ul>
            </li>


            <li>
                <a name="wheeloffset"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>What is the wheel offset? </h3>
                    <!-- Выводим значение поля wheel offset для данной модели по годам. Если значений несколько, то выводим 2 значения - минимальное wheeloffset_min и максимальное wheeloffset_max -->
                    Based on your studs being 1/2 inch, your wheels being 15 inches in diameter, and your lug nuts being coned you would want to torque your lug nuts to 90-120 ft lbs of torque.
                </ul>
            </li>


            <li>
                <a name="backspace"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>What is the wheel backspace? </h3>
                    <!-- Выводим значение backspace для данной модели по годам. Если значений несколько, то выводим 2 значения - минимальное backspace_min и максимальное backspace_max -->
                    Based on your studs being 1/2 inch, your wheels being 15 inches in diameter, and your lug nuts being coned you would want to torque your lug nuts to 90-120 ft lbs of torque. <a href="#">Read More</a>
                </ul>
            </li>


            <li>
                <a name="typicalrimweight"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>Why is the wheel weight matters? </h3>
                    <!-- Выводим значение wheel weight для данной модели по годам. Если значений несколько, то выводим 2 значения - минимальное wheelweight_min и максимальное wheelweight_max -->
                    Based on your studs being 1/2 inch, your wheels being 15 inches in diameter, and your lug nuts being coned you would want to torque your lug nuts to 90-120 ft lbs of torque. <a href="#">Read More</a>
                </ul>
            </li>


        </ul>
    </section>

    <section class="make">
        <h2 class="section-name_2">Tires Specs FAQ</h2>
        <ul class="make__vehicle">
            <li>
                <div class="make__vehicle-image">
                    <a name="tyresize"></a>
                    <a title="Toyota Camry tire size" href="/tires/toyota/camry/">
                        <img alt="Toyota Camry tire size" src="bolt-pattern.jpg">
                    </a>
                </div>
                <ul>
                    <h3>What is the tyre size of a 2019 Toyota Camry?</h3>

                    Rim Sizes are 16x6.0 - 18x7.0. Bolt pattern or bolt circle is the diameter of an imaginary circle formed by the centers of the wheel lugs. <br>You can change Bolt Pattern to 5x100, 5x127 and other by using <a href="#">Wheel Adapters</a>
                </ul>
            </li>


            <li>
                <a name="sidewallheight"></a>
                <div class="make__vehicle-image">
                    <a title="Toyota Camry tire size" href="/tires/toyota/camry/">
                        <img alt="Toyota Camry tire size" src="bolt-pattern.jpg">
                    </a>
                </div>
                <ul>
                    <h3>What is the sidewall height on a 2019 Toyota Camry?</h3>
                    Bolt pattern is 5x114.3. Bolt pattern or bolt circle is the diameter of an imaginary circle formed by the centers of the wheel lugs. <br>You can change Bolt Pattern to 5x100, 5x127 and other by using <a href="#">Wheel Adapters</a>
                </ul>
            </li>


            <li>
                <a name="loadindex"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>What is the load index on a 2019 Toyota Camry?</h3>
                    Bolt pattern is 5x114.3. Bolt pattern or bolt circle is the diameter of an imaginary circle formed by the centers of the wheel lugs. <br>You can change Bolt Pattern to 5x100, 5x127 and other by using <a href="#">Wheel Adapters</a>
                </ul>
            </li>


            <li>
                <a name="speedrating"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>What is the speed rating on a 2019 Toyota Camry?</h3>
                    Bolt pattern is 5x114.3. Bolt pattern or bolt circle is the diameter of an imaginary circle formed by the centers of the wheel lugs. <br>You can change Bolt Pattern to 5x100, 5x127 and other by using <a href="#">Wheel Adapters</a>
                </ul>
            </li>


            <li>
                <a name="tyrepressure"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>What is the tyre pressure on a 2019 Toyota Camry?</h3>
                    You can change Bolt Pattern to 5x100, 5x127 and other by using <a href="#">Wheel Adapters</a>. Bolt pattern is 5x114.3. Bolt pattern or bolt circle is the diameter of an imaginary circle formed by the centers of the wheel lugs.
                </ul>
            </li>


            <li>
                <a name="wheeldiameter"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>What is the Wheel Diameter on a 2019 Toyota Camry?</h3>
                    Based on your studs being 1/2 inch, your wheels being 15 inches in diameter, and your lug nuts being coned you would want to torque your lug nuts to 90-120 ft lbs of torque.
                </ul>
            </li>


            <li>
                <a name="circumference"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>What is the Circumference?</h3>
                    Based on your studs being 1/2 inch, your wheels being 15 inches in diameter, and your lug nuts being coned you would want to torque your lug nuts to 90-120 ft lbs of torque.
                </ul>
            </li>


            <li>
                <a name="revskm"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>How many revolutions? </h3>
                    Based on your studs being 1/2 inch, your wheels being 15 inches in diameter, and your lug nuts being coned you would want to torque your lug nuts to 90-120 ft lbs of torque.
                </ul>
            </li>


            <li>
                <a name="wheeltotyreratio"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>What is the wheel to tyre ratio? </h3>
                    Based on your studs being 1/2 inch, your wheels being 15 inches in diameter, and your lug nuts being coned you would want to torque your lug nuts to 90-120 ft lbs of torque. <a href="#">Read More</a>
                </ul>
            </li>


            <li>
                <a name="typicaltyreweight"></a>
                <div class="make__vehicle-image">
                    <img alt="Toyota Camry Center Bore" src="bolt-pattern.jpg">
                </div>

                <ul>
                    <h3>Why is the typical tyre weight? </h3>
                    Based on your studs being 1/2 inch, your wheels being 15 inches in diameter, and your lug nuts being coned you would want to torque your lug nuts to 90-120 ft lbs of torque. <a href="#">Read More</a>
                </ul>
            </li>


        </ul>
    </section>
	<?php */?>





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
