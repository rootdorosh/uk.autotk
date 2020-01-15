<?php 

return [
    'title' => 'Модуль "Core"',
    'items' => [
        'banner' => [
            'title' => 'Banner',
            'actions' => [
                'core.banner.index' => 'permission.index',
                'core.banner.store' => 'permission.store',
                'core.banner.update' => 'permission.update',
                'core.banner.show' => 'permission.show',
                'core.banner.destroy' => 'permission.destroy',
            ],
        ],
        'domain' => [
            'title' => 'Domain',
            'actions' => [
                'core.domain.index' => 'permission.index',
                'core.domain.store' => 'permission.store',
                'core.domain.update' => 'permission.update',
                'core.domain.show' => 'permission.show',
                'core.domain.destroy' => 'permission.destroy',
            ],
        ],
        'page' => [
            'title' => 'Page',
            'actions' => [
                'core.page.index' => 'permission.index',
                'core.page.store' => 'permission.store',
                'core.page.update' => 'permission.update',
                'core.page.show' => 'permission.show',
                'core.page.destroy' => 'permission.destroy',
            ],
        ],
        'seo' => [
            'title' => 'Seo',
            'actions' => [
                'core.seo.index' => 'permission.index',
                'core.seo.store' => 'permission.store',
                'core.seo.update' => 'permission.update',
                'core.seo.show' => 'permission.show',
                'core.seo.destroy' => 'permission.destroy',
            ],
        ],
    ],
];