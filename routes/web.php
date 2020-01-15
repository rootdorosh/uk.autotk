<?php

use App\Base\CoreHelper;
use App\Modules\Core\Services\Fetch\SeoFetchService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('detect.domain')
    ->group(function () {

    $urlMap = FrontPage::getUrlMap();

    Route::get($urlMap['home'], 'HomeController@index')->name('home');
    Route::get($urlMap['wheels'], 'WheelsController@index')->name('wheels');
    Route::get($urlMap['wheels.make'], 'WheelsController@make')->name('wheels.make');
    Route::get($urlMap['wheels.make.model'], 'WheelsController@model')->name('wheels.make.model');  
    
    Route::get('ajax/get-list-makes-by-year/{year}', 'AjaxController@getListMakesByYear');        
    Route::get('ajax/get-list-models-by-year-and-make-id/{year}/{makeId}', 'AjaxController@getListModelsByYearAndMakeId');        
});


Route::get('flush', function() {
    \Cache::flush();
});

foreach (CoreHelper::getModules() as $module) {
    $file = app_path() . '/Modules/' . $module . '/Admin/Http/routes.php';
    if (is_file($file)) {
        include $file;
    }
}