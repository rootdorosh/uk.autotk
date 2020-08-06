<?php

namespace App\Http\Controllers;

use App\Modules\Auto\Services\Fetch\EngineFetchService;
use App\Modules\Auto\Services\Fetch\MarketFetchService;
use App\Modules\Auto\Services\Fetch\TrimFetchService;
use App\Modules\Auto\Services\Fetch\TrimWheelFetchService;
use Illuminate\Http\Request;
use App\Modules\Auto\Services\Fetch\ModelFetchService;
use App\Modules\Auto\Services\Fetch\ModelYearFetchService;
use App\Modules\Auto\Services\Fetch\MakeFetchService;
use App\Modules\Auto\Services\View\ModelViewService;
use FrontPage;

class WheelsController extends Controller
{
    /*
     * @var MakeFetchService
     */
    private $makeFetchService;

    /*
     * @var ModelFetchService
     */
    private $modelFetchService;

    /*
     * @var ModelYearFetchService
     */
    private $modelYearFetchService;

    /*
     * @var ModelViewService
     */
    private $modelViewService;

    /*
     * HomeController constructor
     *
     * @param MakeFetchService $makeFetchService
     * @param ModelFetchService $modelFetchService
     * @param ModelYearFetchService $modelYearFetchService
     * @param ModelViewService $modelViewService
     */
    public function __construct(
        MakeFetchService $makeFetchService,
        ModelFetchService $modelFetchService,
        ModelYearFetchService $modelYearFetchService,
        ModelViewService $modelViewService
    )
    {
        $this->makeFetchService = $makeFetchService;
        $this->modelFetchService = $modelFetchService;
        $this->modelYearFetchService = $modelYearFetchService;
        $this->modelViewService = $modelViewService;
    }

    /*
     * Home
     */
    public function index()
    {
        $seo = FrontPage::getSeo('wheels');

        return view('front.wheels.index');
    }

    /*
     * Make
     */
    public function make(string $makeAlias)
    {
        $pageAlias = 'wheels.make';

        $make = $this->makeFetchService->getItemBySlug($makeAlias);
        if ($make === null) {
            abort(404);
        }

        $models = $this->modelFetchService->getItemsByMakeIdWheels($make['id']);
        $startYear = $this->modelYearFetchService->getItemStartByMakeId($make['id']);
        $modelMostWheels = $this->modelFetchService->getItemWithMostWheelsByMakeId($make['id']);
        $banners = FrontPage::getBanners($pageAlias);

        $seo = FrontPage::getSeo($pageAlias, [
            'make' => $make['title'],
            'count' => count($models),
            'start_year' => $startYear['year'],
            'start_model_year' => $startYear['model_title'],
            'count_most_rims' => $modelMostWheels['count_wheels'],
            'model_most_rims' => $modelMostWheels['model_title'],
        ]);

        FrontPage::setBreadcrumbs($seo['breadc_title'], $seo['breadc_label']);

        return view('front.wheels.make', compact(
            'make',
            'models',
            'seo',
            'banners'
        ));
    }

    /*
     * Model
     */
    public function model(string $makeAlias, string $modelAlias)
    {
        $make = $this->makeFetchService->getItemBySlug($makeAlias);
        if ($make === null) {
            abort(404);
        }

        $model = $this->modelFetchService->getItemByMakeIdAndSlug($make['id'], $modelAlias);
        if ($model === null) {
            abort(404);
        }

        // ajax
        $defaultSelectedMarketId = 3;
        $action = request()->get('action');
        if ($action) {
            $response = [];

            if ($action === 'markets') {
                $items = (new MarketFetchService)->getItemsByModelIdAndYearFromTrim($model['id'], request()->get('year'));
                foreach ($items as $k => $v) {
                    $response['items'][] = [
                        'id' => $k,
                        'title' => $v,
                        'selected' => $defaultSelectedMarketId == $k,
                    ];
                }
            } elseif ($action === 'engines') {
                $items = (new EngineFetchService)->getItemsByModelIdAndYearAndMarketIdFromTrim($model['id'], request()->get('year'), request()->get('market_id'));
                foreach ($items as $k => $v) {
                    $response['items'][] = [
                        'id' => $k,
                        'title' => $v,
                    ];
                }
            } elseif ($action === 'items') {
                $filteredItems = (new TrimFetchService)->getItemsByModelIdAndYearAndMarketIdAndEngineIdFromTrim($model['id'], request()->get('year'), request()->get('market_id'), request()->get('engine_id'));
                $response['html'] = view('front.wheels._model_filtered_items', compact('filteredItems', 'make', 'model'))->render();
            }

            return response($response);
        }


        $seo = FrontPage::getSeo('wheels.make.model', [
            'make' => $make['title'],
            'model' => $model['title'],
        ]);

        FrontPage::setBreadcrumbs(
            FrontPage::getSeoParamByPage('wheels.make', 'breadc_title', ['make' => $make['title']]),
            FrontPage::getSeoParamByPage('wheels.make', 'breadc_label', ['make' => $make['title']])
        );

        $this->modelViewService->add($model['id']);

        $years = (new ModelYearFetchService)->getItemsByModelIdFromTrim($model['id']);
        $markets = count($years) ? (new MarketFetchService)->getItemsByModelIdAndYearFromTrim($model['id'], $years[0]) : [];
        $selectedMarketId = null;
        if (count($markets)) {
            $selectedMarketId = isset($markets[3]) ? $defaultSelectedMarketId : array_keys($markets)[0];
        }
        $engines = $selectedMarketId ? (new EngineFetchService())->getItemsByModelIdAndYearAndMarketIdFromTrim($model['id'], $years[0], $selectedMarketId) : [];
        $selectedEnginesId = count($engines) ? array_keys($engines)[0] : null;

        $filteredItems = $selectedEnginesId
            ? (new TrimFetchService)->getItemsByModelIdAndYearAndMarketIdAndEngineIdFromTrim(
                $model['id'],
                $years[0],
                $selectedMarketId,
                $selectedEnginesId
            )
            : [];

        $filteredTitle = null;
        if ($selectedEnginesId) {
            $filteredTitle = implode(' ', [$make['title'], $model['title'], $years[0], $engines[$selectedEnginesId]]);
        }
			
		$rimData = (new TrimWheelFetchService)->getGroupByRimDiameterByModelId($model['id']);
        	
        return view('front.wheels.model', compact(
            'make',
            'model',
            'seo',
            'rimData',
            'years',
            'markets',
            'selectedMarketId',
            'selectedEnginesId',
            'engines',
            'filteredItems',
            'filteredTitle'
        ));
    }
}
