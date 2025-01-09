<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder cho bảng slides
        DB::table('slides')->insert([
            [
                'id' => 1,
                'name' => 'Main Slide',
                'keyword' => 'main-slide',
                'description' => null,
                'item' => json_encode([
                    [
                        "image" => "/userfiles/image/Slides/banner-1.jpg",
                        "name" => null,
                        "description" => null,
                        "canonical" => null,
                        "alt" => null,
                        "window" => ""
                    ],
                    [
                        "image" => "/userfiles/image/Slides/banner-2.jpg",
                        "name" => null,
                        "description" => null,
                        "canonical" => null,
                        "alt" => null,
                        "window" => ""
                    ],
                    [
                        "image" => "/userfiles/image/Slides/banner-3.jpg",
                        "name" => null,
                        "description" => null,
                        "canonical" => null,
                        "alt" => null,
                        "window" => ""
                    ]
                ]),
                'publish' => 1,
                'setting' => json_encode([
                    "animation" => "coverflow",
                    "arrow" => "accept",
                    "navigate" => "dots",
                    "autoplay" => "accept",
                    "animationdelay" => 3000,
                    "animationspeed" => 0
                ]),
                'short_code' => '<p>None</p>',
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
