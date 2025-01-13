<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_catalogues')->insert([
            [
                'id' => 1,
                'parent_id' => 0,
                'lft' => 6,
                'rgt' => 7,
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
                'id' => 3,
                'parent_id' => 0,
                'lft' => 2,
                'rgt' => 3,
                'level' => 1,
                'image' => null,
                'icon' => null,
                'album' => 1,
                'publish' => 1,
                'follow' => 0,
                'order' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null
            ],
        ]);

        // Seeder cho bảng product_catalogue_language
        DB::table('product_catalogue_language')->insert([
            [
                'product_catalogue_id' => 1,
                'language_id' => 1,
                'name' => 'Thời trang nam',
                'description' => null,
                'content' => null,
                'meta_title' => 'Thời trang nam',
                'meta_keyword' => null,
                'meta_description' => null,
                'canonical' => 'thoi-trang-nam',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_catalogue_id' => 2,
                'language_id' => 1,
                'name' => 'Thời trang nữ',
                'description' => null,
                'content' => null,
                'meta_title' => 'Thời trang nữ',
                'meta_keyword' => null,
                'meta_description' => null,
                'canonical' => 'thoi-trang-nu',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'product_catalogue_id' => 3,
                'language_id' => 1,
                'name' => 'Phụ kiện',
                'description' => null,
                'content' => null,
                'meta_title' => 'Phụ kiện',
                'meta_keyword' => null,
                'meta_description' => null,
                'canonical' => 'phu-kien',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
