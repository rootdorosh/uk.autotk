<?php

return [
    'id' => '02',
    'name' => 'Domain',
    'name_plural' => 'Domains',
    'table' => 'core_domains',
    'menu' => [
        'icon' => 'fa-globe',
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
        'is_active' => [
            'label' => 'Active',
            'required' => true,
            'type' => 'integer',
            'field' => [
                'type' => 'toggle',
            ],
            'rules' => [
                'in:0,1',
            ],
            'filter' => true,
            'faker' => 'rand(0,1)',
            'migration' => [
                'type' => 'boolean',
                'default' => 0,
            ],
        ],
        'lang' => [
            'label' => 'Language',
            'required' => true,
            'type' => 'string',
            'field' => [
                'type' => 'select',
                'options' => 'array_flip(config(\'translatable.locales\'))',
            ],
            'rules' => [
                'max:255',
            ],
            'faker' => null,
            'migration' => [
                'type' => 'string',
                'nullable' => true
            ],
        ],
        'code' => [
            'label' => 'Code',
            'required' => true,
            'type' => 'string',
            'field' => [
                'type' => 'text',
            ],
            'rules' => [
                'min:2,max:2',
            ],
            'faker' => null,
            'migration' => [
                'type' => 'string',
                'nullable' => true
            ],
        ],
        'rank' => [
            'label' => 'Rank',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                'min:0',
            ],
            'field' => [
                'type' => 'number',
            ],
            'filter' => true,
            'faker' => 'rand(0,10)',
            'migration' => [
                'type' => 'integer',
                'default' => 0
            ],
        ],
    ],
    'translatable' => [
        'owner_id' => 'domain_id',
        'fields' => [
            'title' => [
                'label' => 'Title',
                'type' => 'string',
                'required' => true,
                'rules' => [
                    'max:255',
                ],    
                'filter' => true,
                'faker' => 'null',
            ],
        ],
    ],
    'classMap' => [
        'skipRequest' => [], 
    ],
    'routes' => [
        'path' => 'domains',
        //'update_verb' => 'PUT', //POST if image store
    ],
];