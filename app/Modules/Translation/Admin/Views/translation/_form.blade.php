<?= FormBuilder::create([
       'method' => $translation->exists ? 'PUT' : 'POST',
       'action' => $action,
       'model'  => $translation,
       'id'  => 'form-translation',
       'groupClass' => 'form-group col-sm-4',
       'tab' => 'main',
    ], function (App\Services\Form\Form $form) use ($translation) {
         
		$form->addTab('main', [
			'title' => __('translation::translation.title.singular'),
		]);    

		foreach (config('translatable.locales') as $locale) {
			$form->addTab('locale-' . $locale, [
				'title' => $locale,
			]);
		}    
        
		$form->text('slug');        

		foreach (config('translatable.locales') as $locale) {
			$form->text($locale . "[value]", [
				'tab' => 'locale-' . $locale,
			]);
		}    
    
        $form->button('submit', 'btn-success btn-sm', __('app.submit'));
});?>    