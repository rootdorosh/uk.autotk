<?php

return [
    'id' => '01',
    'name' => 'Translation',
    'name_plural' => 'Translations',
    'table' => 'translations',
    // if not use on simple template
    'menu' => [
        'icon' => 'fa-file-text-o',
    ],
    'fields' => [
        'slug' => [
            'label' => 'Slug',
            'type' => 'string',
            'field' => [
                'type' => 'text',
            ],
            'required' => true,
            'rules' => [
            ],
            'filter' => true,
        ],
    ],
    'translatable' => [
        'owner_id' => 'trans_id',
        'fields' => [
            'value' => [
                'label' => 'Value',
                'type' => 'string',
                'required' => true,
                'rules' => [
                    'max:255',
                ],    
                'filter' => true,
            ],
        ],
    ],
    'classMap' => [
        'skipRequest' => [], 
    ],
    'skipMap' => [
        'factory',
    ],
    'routes' => [
        'path' => 'translations',
        //'update_verb' => 'PUT', //POST if image store
    ],
];