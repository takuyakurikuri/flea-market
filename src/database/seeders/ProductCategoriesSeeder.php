<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'content' => 'ファッション'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => '家電'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => 'インテリア'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => 'レディース'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => 'メンズ'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => 'コスメ'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => '本'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => 'ゲーム'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => 'スポーツ'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => 'キッチン'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => 'ハンドメイド'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => 'アクセサリー'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => 'おもちゃ'
        ];

        DB::table('product_categories')->insert($param);

        $param = [
            'content' => 'ベビー・キッズ'
        ];

        DB::table('product_categories')->insert($param);
    }
}