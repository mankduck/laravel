<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('languages')->insert([
            [
                'name' => 'Vietnamese',
                'canonical' => 'vn',
                'image' => '/userfiles/image/languages/Flag_of_Vietnam_svg.webp',
                'user_id' => 1,
                'publish' => 2,
                'current' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'English',
                'canonical' => 'en',
                'image' => '/userfiles/image/languages/england.png',
                'user_id' => 1,
                'publish' => 2,
                'current' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Chinese',
                'canonical' => 'cn',
                'image' => '/userfiles/image/languages/china.png',
                'user_id' => 1,
                'publish' => 2,
                'current' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
