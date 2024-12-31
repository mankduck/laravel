<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_catalogues')->insert([
            [
                'name' => 'Admin',
                'description' => '',
                'publish' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'User',
                'description' => '',
                'publish' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'), // Mã hóa mật khẩu
                'publish' => 2,
                'user_catalogue_id' => 1, // Giả định rằng bạn đã có một role với ID = 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678'), // Mã hóa mật khẩu
                'publish' => 2,
                'user_catalogue_id' => 2, // Giả định rằng bạn đã có một role với ID = 1
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
