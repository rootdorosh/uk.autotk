<?= FormBuilder::create([
       'method' => $domain->exists ? 'PUT' : 'POST',
       'action' => $action,
       'model'  => $domain,
       'id'  => 'form-domain',
       'groupClass' => 'form-group col-sm-4',
       'tab' => 'main',
    ], function (App\Services\Form\Form $form) use ($domain) {
         
		$form->addTab('main', [
			'title' => __('core::domain.title.singular'),
		]);    

		foreach (config('translatable.locales') as $locale) {
			$form->addTab('locale-' . $locale, [
				'title' => $locale,
			]);
		}    
        
		$form->text('alias');

		$form->toggle('is_active');

		$form->select('lang', array_list(config('translatable.locales')));

		$form->text('code');

		$form->number('rank');        

		foreach (config('translatable.locales') as $locale) {
			$form->text($locale . "[title]", [
				'tab' => 'locale-' . $locale,
			]);
		}    
    
        $form->button('submit', 'btn-success btn-sm', __('app.submit'));
});?>    