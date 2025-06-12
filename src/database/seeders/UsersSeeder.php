<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create();

        $param = [
            'name' => 'testUser01',
            'email' => 'testuser01@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'image_path' => 'images/pag.jpg',
            'address_id' => 1,
        ];

        DB::table('users')->insert($param);

        $param = [
            'name' => 'testUser02',
            'email' => 'testuser02@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'image_path' => 'images/pag.jpg',
            'address_id' => 2,
        ];

        DB::table('users')->insert($param);

        $param = [
            'name' => 'testUser03',
            'email' => 'testuser03@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'image_path' => 'images/pag.jpg',
            'address_id' => 3,
        ];

        DB::table('users')->insert($param);
    }
}