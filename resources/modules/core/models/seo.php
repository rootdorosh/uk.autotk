<?php

return [
    'id' => '03',
    'name' => 'Seo',
    'name_plural' => 'Seos',
    'table' => 'core_seo',
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
                'foreign' => ['core_domains', 'CASCADE'],
                'type' => 'unsignedInteger',
            ],
        ],
        'url' => [
            'label' => 'Url',
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
                'nullable' => true,
            ],
        ],
        'title' => [
            'label' => 'Seo title',
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
                'nullable' => true,
            ],
        ],
        'description' => [
            'label' => 'Seo description',
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
                'nullable' => true,
            ],
        ],
        'keywords' => [
            'label' => 'Seo keywords',
            'type' => 'string',
            'field' => [
                'type' => 'text',
            ],
            'rules' => [
				'max:255',
            ],
            'migration' => [
				'type' => 'string',
                'nullable' => true,
            ],
        ],
        'header_text' => [
            'label' => 'Header text',
            'type' => 'string',
            'field' => [
                'type' => 'text',
            ],
            'rules' => [
            ],
            'migration' => [
				'type' => 'text',
                'nullable' => true,
            ],
        ],
        'footer_text' => [
            'label' => 'Header text',
            'type' => 'string',
            'field' => [
                'type' => 'text',
            ],
            'rules' => [
            ],
            'migration' => [
				'type' => 'text',
                'nullable' => true,
            ],
        ],
        'breadc_label' => [
            'label' => 'Breadcrumbs label',
            'type' => 'string',
            'field' => [
                'type' => 'string',
            ],
            'rules' => [
				'max:255',
            ],
            'migration' => [
				'type' => 'string',
                'nullable' => true,
            ],
        ],
        'breadc_title' => [
            'label' => 'Breadcrumbs title',
            'type' => 'string',
            'field' => [
                'type' => 'string',
            ],
            'rules' => [
				'max:255',
            ],
            'migration' => [
				'type' => 'string',
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