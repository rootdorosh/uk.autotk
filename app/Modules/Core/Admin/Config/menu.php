<?php 

return [
    [
        'module' => 'core',
        'title' => 'Domains & pages',
        'route' => '#',
        'icon' => ' fa-sitemap',
        'permission' => 'core.page.index',
        'rank' => 1,
        'children' => [
            [
                'title' => 'Domains',
                'route' => route('admin.core.domains.index'),
                'icon' => 'fa-globe',
                'permission' => 'core.domain.index',
            ],
            [
                'title' => 'Pages',
                'route' => route('admin.core.pages.index'),
                'icon' => 'fa-folder',
                'permission' => 'core.page.index',
            ],
        ],
    ],
];