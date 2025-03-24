<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'item_id' => '1',
            'category_id' => '1'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '1',
            'category_id' => '5'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '2',
            'category_id' => '2'
        ];

        DB::table('category_item')->insert($param);
        
        $param = [
            'item_id' => '3',
            'category_id' => '10'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '4',
            'category_id' => '1'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '4',
            'category_id' => '5'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '4',
            'category_id' => '12'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '5',
            'category_id' => '2'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '6',
            'category_id' => '2'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '6',
            'category_id' => '3'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '7',
            'category_id' => '1'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '7',
            'category_id' => '4'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '8',
            'category_id' => '9'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '9',
            'category_id' => '3'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '9',
            'category_id' => '10'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '10',
            'category_id' => '4'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '10',
            'category_id' => '6'
        ];

        DB::table('category_item')->insert($param);

        //2週目
        
        $param = [
            'item_id' => '11',
            'category_id' => '1'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '11',
            'category_id' => '5'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '12',
            'category_id' => '2'
        ];

        DB::table('category_item')->insert($param);
        
        $param = [
            'item_id' => '13',
            'category_id' => '10'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '14',
            'category_id' => '1'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '14',
            'category_id' => '5'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '14',
            'category_id' => '12'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '15',
            'category_id' => '2'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '16',
            'category_id' => '2'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '16',
            'category_id' => '3'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '17',
            'category_id' => '1'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '17',
            'category_id' => '4'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '18',
            'category_id' => '9'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '19',
            'category_id' => '3'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '19',
            'category_id' => '10'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '20',
            'category_id' => '4'
        ];

        DB::table('category_item')->insert($param);

        $param = [
            'item_id' => '20',
            'category_id' => '6'
        ];

        DB::table('category_item')->insert($param);
    }
}