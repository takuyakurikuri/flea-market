<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemCategoriesSeeder extends Seeder
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

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => '家電'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => 'インテリア'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => 'レディース'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => 'メンズ'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => 'コスメ'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => '本'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => 'ゲーム'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => 'スポーツ'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => 'キッチン'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => 'ハンドメイド'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => 'アクセサリー'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => 'おもちゃ'
        ];

        DB::table('item_categories')->insert($param);

        $param = [
            'content' => 'ベビー・キッズ'
        ];

        DB::table('item_categories')->insert($param);
    }
}