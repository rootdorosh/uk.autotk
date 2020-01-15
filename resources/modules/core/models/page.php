<?php

return [
    'id' => '01',
    'name' => 'Page',
    'name_plural' => 'Pages',
    'table' => 'core_pages',
    'menu' => [
        'icon' => 'fa-folder',
    ],    
    'fields' => [
        'alias' => [
            'label' => 'Alias',
            'type' => 'string',
            'field' => [
                'type' => 'text',
            ],
            'required' => true,
            'rules' => [
            ],
            'filter' => true,
            'faker' => null,
        ],
        'title' => [
            'label' => 'Title',
            'required' => true,
            'type' => 'string',
            'field' => [
                'type' => 'text',
            ],
            'rules' => [
            ],
            'faker' => null,
            'filter' => true,
            'migration' => [
                'type' => 'string',
                'nullable' => true
            ],
        ],
    ],
    'classMap' => [
        'skipRequest' => ['BulkToggleRequest'], 
    ],
    'routes' => [
        'path' => 'pages',
    ],
];