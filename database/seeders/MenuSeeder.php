<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder cho bảng catalogues
        DB::table('menu_catalogues')->insert([
            'id' => 1,
            'name' => 'Menu Header',
            'keyword' => 'menu-header',
            'publish' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seeder cho bảng menus
        DB::table('menus')->insert([
            // Menu 1
            [
                'id' => 1,
                'parent_id' => 0,
                'menu_catalogue_id' => 1,
                'lft' => 2,
                'rgt' => 3,
                'level' => 1,
                'type' => null,
                'image' => null,
                'icon' => null,
                'album' => null,
                'publish' => 1,
                'order' => 6,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            // Menu 2
            [
                'id' => 2,
                'parent_id' => 0,
                'menu_catalogue_id' => 1,
                'lft' => 4,
                'rgt' => 9,
                'level' => 1,
                'type' => null,
                'image' => null,
                'icon' => null,
                'album' => null,
                'publish' => 1,
                'order' => 4,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            // Menu 3
            [
                'id' => 3,
                'parent_id' => 2,
                'menu_catalogue_id' => 1,
                'lft' => 5,
                'rgt' => 6,
                'level' => 2,
                'type' => null,
                'image' => null,
                'icon' => null,
                'album' => null,
                'publish' => 1,
                'order' => 2,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            // Menu 4
            [
                'id' => 4,
                'parent_id' => 2,
                'menu_catalogue_id' => 1,
                'lft' => 7,
                'rgt' => 8,
                'level' => 2,
                'type' => null,
                'image' => null,
                'icon' => null,
                'album' => null,
                'publish' => 1,
                'order' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            // Menu 5
            [
                'id' => 5,
                'parent_id' => 0,
                'menu_catalogue_id' => 1,
                'lft' => 10,
                'rgt' => 11,
                'level' => 1,
                'type' => null,
                'image' => null,
                'icon' => null,
                'album' => null,
                'publish' => 1,
                'order' => 3,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            // Menu 6
            [
                'id' => 6,
                'parent_id' => 0,
                'menu_catalogue_id' => 1,
                'lft' => 12,
                'rgt' => 13,
                'level' => 1,
                'type' => null,
                'image' => null,
                'icon' => null,
                'album' => null,
                'publish' => 1,
                'order' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            // Menu 7
            [
                'id' => 7,
                'parent_id' => 0,
                'menu_catalogue_id' => 1,
                'lft' => 14,
                'rgt' => 15,
                'level' => 1,
                'type' => null,
                'image' => null,
                'icon' => null,
                'album' => null,
                'publish' => 1,
                'order' => 2,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            // Menu 8
            [
                'id' => 8,
                'parent_id' => 0,
                'menu_catalogue_id' => 1,
                'lft' => 16,
                'rgt' => 17,
                'level' => 1,
                'type' => null,
                'image' => null,
                'icon' => null,
                'album' => null,
                'publish' => 1,
                'order' => 5,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
        ]);

        // Seeder cho bảng menu_language
        DB::table('menu_language')->insert([
            [
                'menu_id' => 1,
                'language_id' => 1,
                'name' => 'Trang chủ',
                'canonical' => '/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => 2,
                'language_id' => 1,
                'name' => 'Thời trang',
                'canonical' => '/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => 3,
                'language_id' => 1,
                'name' => 'Thời trang nữ',
                'canonical' => 'thoi-trang-nu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => 4,
                'language_id' => 1,
                'name' => 'Thời trang nam',
                'canonical' => 'thoi-trang-nam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => 5,
                'language_id' => 1,
                'name' => 'Phụ kiện',
                'canonical' => 'phu-kien',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => 6,
                'language_id' => 1,
                'name' => 'Liên hệ',
                'canonical' => 'lien-he',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => 7,
                'language_id' => 1,
                'name' => 'Bài viết',
                'canonical' => 'bai-viet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_id' => 8,
                'language_id' => 1,
                'name' => 'Giới thiệu',
                'canonical' => 'gioi-thieu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
