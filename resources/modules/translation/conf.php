<?php

return [
    'name' => 'Translation',
    'menu' => [
		'permission' => 'translation.translation.index',
		'icon' => ' fa-file',
		'title' => 'Translations',
        'template' => 'simple',
        // use only simple template
        'route' => 'translation.translations',
	],
];