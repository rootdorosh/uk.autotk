<?php

return [
    'id' => '04',
    'name' => 'Banner',
    'name_plural' => 'Banners',
    'table' => 'core_banners',
	'migration' => [
		'skipId' => true,
		'unique' => "['page_id', 'domain_id']",
	],
	'fields' => [
        'page_id' => [
            'label' => 'Page',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                'integer',
                'exists:core_pages,id',
            ],
            'relation' => [
                'name' => 'page',
                'type' => 'BelongsTo',
                'model' => 'App\Modules\Core\Models\Page',
            ],
            'migration' => [
                'foreign' => ['core_pages', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],
        'domain_id' => [
            'label' => 'Domain',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                'integer',
                'exists:core_domains,id',
            ],
            'relation' => [
                'name' => 'domain',
                'type' => 'BelongsTo',
                'model' => 'App\Modules\Core\Models\Domain',
            ],
            'migration' => [
                'foreign' => ['core_pages', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],
        'position' => [
            'label' => 'Position',
            'type' => 'string',
            'field' => [
                'type' => 'text',
            ],
            'required' => true,
            'rules' => [
				'max:255',
            ],
            'migration' => [
				'type' => 'string',
            ],
        ],
        'content' => [
            'label' => 'Content',
            'type' => 'string',
            'field' => [
                'type' => 'text',
            ],
            'migration' => [
				'type' => 'text',
                'nullable' => true,
            ],
        ],
    ],
    'skipMap' => [
		'menu',
		'permission',
		'request',
		'controller',
		'view',
		'routes',
		'crudService',
		'factory',
	],
];