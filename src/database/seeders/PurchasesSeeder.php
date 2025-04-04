<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;

class PurchasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = User::all();
        $items = Item::all();
        $addresses = Address::all();
        
        $param = [
            'user_id' => $users->random()->id,
            'payment_method' => '1',
            'item_id' => $items->random()->id,
            'address_id' => $addresses->random()->id,
        ];

        DB::table('purchases')->insert($param);

        $param = [
            'user_id' => $users->random()->id,
            'payment_method' => '1',
            'item_id' => $items->random()->id,
            'address_id' => $addresses->random()->id,
        ];

        DB::table('purchases')->insert($param);

        $param = [
            'user_id' => $users->random()->id,
            'payment_method' => '2',
            'item_id' => $items->random()->id,
            'address_id' => $addresses->random()->id,
        ];

        DB::table('purchases')->insert($param);

        $param = [
            'user_id' => $users->random()->id,
            'payment_method' => '2',
            'item_id' => $items->random()->id,
            'address_id' => $addresses->random()->id,
        ];

        DB::table('purchases')->insert($param);
    }

    
}