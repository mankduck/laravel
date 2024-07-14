<?php
return [
    'module' => [
        [
            'title' => 'QL Sản Phẩm',
            'icon' => 'fa fa-cube',
            'name' => ['product', 'attribute'],
            'subModule' => [
                [
                    'title' => 'QL Nhóm Sản Phẩm',
                    'route' => 'product/catalogue/index'
                ],
                [
                    'title' => 'QL Sản Phẩm',
                    'route' => 'product/index'
                ],
                [
                    'title' => 'QL Loại Thuộc Tính',
                    'route' => 'attribute/catalogue/index'
                ],
                [
                    'title' => 'QL Thuộc Tính',
                    'route' => 'attribute/index'
                ],

            ]
        ],
        [
            'title' => 'QL Marketing',
            'icon' => 'fa fa-money',
            'name' => ['promotion', 'source'],
            'subModule' => [
                [
                    'title' => 'QL Khuyến Mãi',
                    'route' => 'promotion/index'
                ],
                [
                    'title' => 'QL Nguồn Khách',
                    'route' => 'source/index'
                ]

            ]
        ],
        [
            'title' => 'QL Bài viết',
            'icon' => 'fa fa-file',
            'name' => ['post'],
            'subModule' => [
                [
                    'title' => 'QL Nhóm Bài Viết',
                    'route' => 'post/catalogue/index'
                ],
                [
                    'title' => 'QL Bài Viết',
                    'route' => 'post/index'
                ]
            ]
        ],
        [
            'title' => 'QL Nhóm Thành Viên',
            'icon' => 'fa fa-user',
            'name' => ['user', 'permission'],
            'subModule' => [
                [
                    'title' => 'QL Nhóm Thành Viên',
                    'route' => 'user/catalogue/index'
                ],
                [
                    'title' => 'QL Thành Viên',
                    'route' => 'user/index'
                ],
                [
                    'title' => 'QL Quyền',
                    'route' => 'permission/index'
                ]
            ]
        ],
        [
            'title' => 'QL Banner & Slide',
            'icon' => 'fa fa-image',
            'name' => ['slide'],
            'route' => 'slide/index'
        ],
        [
            'title' => 'QL Menu',
            'icon' => 'fa fa-bar',
            'name' => ['menu'],
            'route' => 'menu/index'
        ],
        [
            'title' => 'Cấu Hình Chung',
            'icon' => 'fa fa-file',
            'name' => ['language', 'generate', 'widget'],
            'subModule' => [
                [
                    'title' => 'QL Ngôn ngữ',
                    'route' => 'language/index'
                ],
                [
                    'title' => 'Cấu Hình Hệ Thống',
                    'route' => 'system/index'
                ],
                [
                    'title' => 'Quản lý Widget',
                    'route' => 'widget/index'
                ],

            ]
        ]
    ],
];
