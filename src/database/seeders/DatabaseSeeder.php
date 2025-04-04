<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategoriesSeeder::class,
            AddressSeeder::class,
            UsersSeeder::class,
            ItemsSeeder::class,
            CategoryItemSeeder::class,
            PurchasesSeeder::class,
        ]);
    }
}