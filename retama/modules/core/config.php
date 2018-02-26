<?php

return [
    'modules' => [
        'dashboard' => [
            'label' => 'Dashboard',
            'icon' => 'fa fa-th-large',
            'enabled' => true,
            'url' => 'dashboard',
        ],
        'content' => [
            'label' => 'Content',
            'icon' => 'fa fa-copy',
            'enabled' => true,
            'url' => 'content',
            'children' => [
                'structure' => [
                    'label' => 'Site Structure',
                    'icon' => 'fa fa-sitemap',
                    'enabled' => '0',
                    'url' => 'content/structure',
                ],
                'navigation' => [
                    'label' => 'Navigation / Menus',
                    'icon' => 'fa fa-bars',
                    'enabled' => '0',
                    'url' => 'content/navigation',
                ],
                'page' => [
                    'label' => 'Pages',
                    'icon' => 'fa fa-file',
                    'enabled' => true,
                    'url' => 'content/pages',
                    'fields' => [
                        'title' => [
                            'label' => 'Title',
                            'enabled' => true,
                        ],
                        'preview' => [
                            'label' => 'Preview',
                            'enabled' => true,
                        ],
                        'body' => [
                            'label' => 'Body',
                            'enabled' => true,
                        ],
                        'extra' => [
                            'label' => 'Extra',
                            'enabled' => true,
                        ],
                    ]
                ]
            ]
        ]
    ]
];
