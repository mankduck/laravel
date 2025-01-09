<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeCatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder cho bảng attribute_catalogues
        DB::table('attribute_catalogues')->insert([
            [
                'id' => 1,
                'parent_id' => 0,
                'lft' => 4,
                'rgt' => 5,
                'level' => 1,
                'image' => null,
                'icon' => null,
                'album' => 2,
                'publish' => 1,
                'follow' => 0,
                'order' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'parent_id' => 0,
                'lft' => 2,
                'rgt' => 3,
                'level' => 1,
                'image' => null,
                'icon' => null,
                'album' => 2,
                'publish' => 1,
                'follow' => 0,
                'order' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
        ]);

        // Seeder cho bảng attribute_catalogue_language
        DB::table('attribute_catalogue_language')->insert([
            [
                'attribute_catalogue_id' => 1,
                'language_id' => 1,
                'name' => 'Màu sắc',
                'description' => null,
                'content' => null,
                'meta_title' => 'Màu sắc',
                'meta_keyword' => null,
                'meta_description' => null,
                'canonical' => 'mau-sac',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'attribute_catalogue_id' => 2,
                'language_id' => 1,
                'name' => 'Chất liệu',
                'description' => null,
                'content' => null,
                'meta_title' => 'Chất liệu',
                'meta_keyword' => null,
                'meta_description' => null,
                'canonical' => 'chat-lieu',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // Seeder cho bảng attributes
        DB::table('attributes')->insert([
            [
                'id' => 1,
                'attribute_catalogue_id' => 1,
                'image' => null,
                'icon' => null,
                'album' => 2,
                'publish' => 1,
                'follow' => 0,
                'order' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'attribute_catalogue_id' => 1,
                'image' => null,
                'icon' => null,
                'album' => 2,
                'publish' => 1,
                'follow' => 0,
                'order' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'attribute_catalogue_id' => 2,
                'image' => null,
                'icon' => null,
                'album' => 2,
                'publish' => 1,
                'follow' => 0,
                'order' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'attribute_catalogue_id' => 2,
                'image' => null,
                'icon' => null,
                'album' => 2,
                'publish' => 1,
                'follow' => 0,
                'order' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ]
        ]);

        // Seeder cho bảng attribute_language
        DB::table('attribute_language')->insert([
            [
                'attribute_id' => 1,
                'language_id' => 1,
                'name' => 'Đen',
                'description' => null,
                'content' => null,
                'meta_title' => 'Đen',
                'meta_keyword' => null,
                'meta_description' => null,
                'canonical' => 'den',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'attribute_id' => 2,
                'language_id' => 1,
                'name' => 'Trắng',
                'description' => null,
                'content' => null,
                'meta_title' => 'Trắng',
                'meta_keyword' => null,
                'meta_description' => null,
                'canonical' => 'trang',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'attribute_id' => 3,
                'language_id' => 1,
                'name' => 'Cotton',
                'description' => null,
                'content' => null,
                'meta_title' => 'Cotton',
                'meta_keyword' => null,
                'meta_description' => null,
                'canonical' => 'cotton',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'attribute_id' => 4,
                'language_id' => 1,
                'name' => 'Vải Kaki',
                'description' => null,
                'content' => null,
                'meta_title' => 'Vải Kaki',
                'meta_keyword' => null,
                'meta_description' => null,
                'canonical' => 'vai-kaki',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Seeder cho bảng attribute_catalogue_attribute
        DB::table('attribute_catalogue_attribute')->insert([
            [
                'attribute_catalogue_id' => 1,
                'attribute_id' => 1
            ],
            [
                'attribute_catalogue_id' => 1,
                'attribute_id' => 2
            ],
            [
                'attribute_catalogue_id' => 2,
                'attribute_id' => 3
            ],
            [
                'attribute_catalogue_id' => 2,
                'attribute_id' => 4
            ]
        ]);

    }
}
