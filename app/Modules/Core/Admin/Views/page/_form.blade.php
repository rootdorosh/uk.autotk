<?php 
use App\Modules\Core\Services\Fetch\DomainFetchService;
use App\Modules\Core\Models\Banner;
?>

<?= FormBuilder::create([
       'method' => $page->exists ? 'PUT' : 'POST',
       'action' => $action,
       'model'  => $page,
       'id'  => 'form-page',
       'groupClass' => 'form-group col-sm-4',
       'tab' => 'main',
       'relations' => ['seo', 'banners'],
    ], function (App\Services\Form\Form $form) use ($page) {
         
		$form->addTab('main', [
			'title' => __('core::page.title.singular'),
		]);    
        
		$form->text('alias');
        $form->text('title');     
        
        foreach ((new DomainFetchService)->getList() as $domainId => $domainTitle) {
            // add tab
            
            $tabId = "domain-$domainId";
            
            $form->addTab($tabId, [
                'title' => $domainTitle,
            ]); 
            
            // add seo fields
            $form->text("seo[$domainId][url]", [
                'tab' => $tabId,
                'title' => __('core::seo.fields.url'),
                'groupClass' => 'col-sm-12',
            ]);
            
            $form->text("seo[$domainId][title]", [
                'tab' => $tabId,
                'title' => __('core::seo.fields.title'),
                'groupClass' => 'col-sm-12',
            ]);
            
            $form->text("seo[$domainId][description]", [
                'tab' => $tabId,
                'title' => __('core::seo.fields.description'),
                'groupClass' => 'col-sm-12',
            ]);
            
            $form->text("seo[$domainId][keywords]", [
                'tab' => $tabId,
                'title' => __('core::seo.fields.keywords'),
                'groupClass' => 'col-sm-12',
            ]);
            
            $form->text("seo[$domainId][h1]", [
                'tab' => $tabId,
                'title' => __('core::seo.fields.h1'),
                'groupClass' => 'col-sm-12',
            ]);

            $form->textarea("seo[$domainId][header_text]", [
                'tab' => $tabId,
                'title' => __('core::seo.fields.header_text'),
                'groupClass' => 'col-sm-6',
            ]);
            
            $form->textarea("seo[$domainId][footer_text]", [
                'tab' => $tabId,
                'title' => __('core::seo.fields.footer_text'),
                'groupClass' => 'col-sm-6',
            ]);

            $form->text("seo[$domainId][breadc_label]", [
                'tab' => $tabId,
                'title' => __('core::seo.fields.breadc_label'),
                'groupClass' => 'col-sm-6',
            ]);
            
            $form->text("seo[$domainId][breadc_title]", [
                'tab' => $tabId,
                'title' => __('core::seo.fields.breadc_title'),
                'groupClass' => 'col-sm-6',
            ]);
            
            foreach (Banner::POSITIONS as $bannerPosition) {
                $form->textarea("banners[$domainId][$bannerPosition]", [
                    'tab' => $tabId,
                    'title' => "Text for banner position $bannerPosition",
                    'groupClass' => 'col-sm-12'
                ]);
            }
        }
    
        $form->button('submit', 'btn-success btn-sm', __('app.submit'));
});?>    