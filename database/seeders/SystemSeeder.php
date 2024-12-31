<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('systems')->insert([
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'homepage_company',
                'content' => 'Công ty Phgmnhd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'homepage_brand',
                'content' => 'Công ty Phgmnhd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'homepage_logo',
                'content' => '/userfiles/image/languages/Flag_of_Vietnam_svg.web...',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'homepage_copyright',
                'content' => 'Công ty Phgmnhd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'homepage_website',
                'content' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'contact_office',
                'content' => 'Hà Nội',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'contact_address',
                'content' => 'Hà Nội',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'contact_hotline',
                'content' => '0889564869',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'contact_technical_phone',
                'content' => '0889564869',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'contact_phone',
                'content' => '0889564869',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'contact_fax',
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'contact_email',
                'content' => 'adphgmnhd@gmail.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'contact_tax',
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'contact_website',
                'content' => 'phgmnhd.id.vn',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'contact_map',
                'content' => '<iframe src="<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1316.5808176944524!2d105.7467355097448!3d21.038571184623578!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455e940879933%3A0xcf10b34e9f1a03df!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1712766928806!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'seo_meta_title',
                'content' => 'Công ty Phgmnhd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'seo_meta_keyword',
                'content' => 'Công ty Phgmnhd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'seo_meta_description',
                'content' => 'Công ty Phgmnhd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'seo_meta_images',
                'content' => '/userfiles/image/languages/Flag_of_Vietnam_svg.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 1,
                'user_id' => 1,
                'keyword' => 'homepage_short_intro',
                'content' => '<p>Công ty Phgmnhd</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 2,
                'user_id' => 1,
                'keyword' => 'homepage_company',
                'content' => 'Company Phgmnhd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 2,
                'user_id' => 1,
                'keyword' => 'homepage_brand',
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 2,
                'user_id' => 1,
                'keyword' => 'homepage_logo',
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 2,
                'user_id' => 1,
                'keyword' => 'homepage_copyright',
                'content' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'language_id' => 2,
                'user_id' => 1,
                'keyword' => 'homepage_website',
                'content' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
