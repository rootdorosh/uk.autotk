<?php 

Route::name('admin.translation.')
    ->namespace('\App\Modules\Translation\Admin\Http\Controllers')
    ->prefix('admin/translation')
    ->middleware('auth')
    ->group(function () {
        
        Route::resource('translations', 'TranslationController');
                    
});