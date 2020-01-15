<?php 

return [
    'title' => 'Модуль "Translation"',
    'items' => [
        'translation' => [
            'title' => 'Translation',
            'actions' => [
                'translation.translation.index' => 'permission.index',
                'translation.translation.store' => 'permission.store',
                'translation.translation.update' => 'permission.update',
                'translation.translation.show' => 'permission.show',
                'translation.translation.destroy' => 'permission.destroy',
            ],
        ],
    ],
];