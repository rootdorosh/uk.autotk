<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FrontPage;
use App\Modules\Auto\Services\Fetch\MakeFetchService;
use App\Modules\Auto\Services\Fetch\ModelFetchService;
use App\Modules\Auto\Services\Fetch\ModelYearFetchService;
use App\Modules\Auto\Services\View\ModelViewService;

class HomeController extends Controller
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
        $seo = FrontPage::getSeo('home');
        $banners = FrontPage::getBanners('home');
        $makes = $this->makeFetchService->getData();
        $mostVisitedModels = $this->modelFetchService->mostVisited();
        $years = $this->modelYearFetchService->getListYears();
        $makes = $this->modelYearFetchService->getListMakesByYear(2020);
        $models = $this->modelYearFetchService->getListModelsByYearAndMakeId(2020, 107);
        
        return view('front.home.index', compact(
            'seo',
            'banners',
            'makes',
            'mostVisitedModels',
            'years'
        ));
    }
}
