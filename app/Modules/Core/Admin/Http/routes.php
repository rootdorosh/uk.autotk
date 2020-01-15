<?php 

Route::name('admin.core.')
    ->namespace('\App\Modules\Core\Admin\Http\Controllers')
    ->prefix('admin/core')
    ->middleware('auth')
    ->group(function () {
        
        Route::resource('domains', 'DomainController');
                
        Route::resource('pages', 'PageController');
                    
});