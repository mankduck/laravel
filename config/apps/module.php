<?php
return [
    'module' => [
        [
            'title' => 'QL Nhóm Thành Viên',
            'icon' => 'fa fa-th-large',
            'name' => 'user',
            'subModule' => [
                [
                    'title' => 'QL Thành Viên',
                    'route' => 'user/index'
                ],
                [
                    'title' => 'QL Nhóm Thành Viên',
                    'route' => 'user/catalogue/index'
                ]
            ]
        ],
        [
            'title' => 'QL Bài Viết',
            'icon' => 'fa fa-th-large',
            'name' => 'post',
            'subModule' => [
                [
                    'title' => 'QL Bài Viết',
                    'route' => 'post/index'
                ],
                [
                    'title' => 'QL Nhóm Bài Viết',
                    'route' => 'post/catalogue/index'
                ]
            ]
        ],
        [
            'title' => 'Cấu Hình Chung',
            'icon' => 'fa fa-th-large',
            'name' => 'language',
            'subModule' => [
                [
                    'title' => 'QL Ngôn ngữ',
                    'route' => 'language/index'
                ],
            ]
        ]
    ]
];