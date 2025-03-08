<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = [
            'Armani+Mens+Clock.jpg' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'HDD+Hard+Disk.jpg' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'iLoveIMG+d.jpg' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'Leather+Shoes+Product+Photo.jpg' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'Living+Room+Laptop.jpg' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'Music+Mic+4632231.jpg' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'Purse+fashion+pocket.jpg' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'Tumbler+souvenir.jpg' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'Waitress+with+Coffee+Grinder.jpg' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            '外出メイクアップセット.jpg' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg'
        ];
        $storagePath = 'public/images';

        foreach($images as $filename => $url){
            if (!Storage::exists("$storagePath/$filename")) {
                $imageData = Http::get($url)->body();
                Storage::put("$storagePath/$filename", $imageData);
            }
        }
        
        $param = [
            'item_image_path' => 'images/Armani+Mens+Clock.jpg',
            'exhibitor_id' => '1000',
            'item_category_id' =>'1',
            'condition_id' => '1',
            'product_name' => '腕時計',
            'product_brand' => 'armani',
            'product_detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'product_price' => '15000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/HDD+Hard+Disk.jpg',
            'exhibitor_id' => '1000',
            'item_category_id' =>'2',
            'condition_id' => '2',
            'product_name' => 'HDD',
            'product_brand' => 'toshiba',
            'product_detail' => '高速で信頼性の高いハードディスク',
            'product_price' => '5000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/iLoveIMG+d.jpg',
            'exhibitor_id' => '1000',
            'item_category_id' =>'3',
            'condition_id' => '3',
            'product_name' => '玉ねぎ3束',
            'product_brand' => 'nagano',
            'product_detail' => '新鮮な玉ねぎ3束のセット',
            'product_price' => '300',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Leather+Shoes+Product+Photo.jpg',
            'exhibitor_id' => '1000',
            'item_category_id' =>'4',
            'condition_id' => '4',
            'product_name' => '革靴',
            'product_brand' => 'edwin',
            'product_detail' => 'クラシックなデザインの革靴',
            'product_price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Living+Room+Laptop.jpg',
            'exhibitor_id' => '1000',
            'item_category_id' =>'5',
            'condition_id' => '1',
            'product_name' => 'ノートPC',
            'product_brand' => 'apple',
            'product_detail' => '高性能なノートパソコン',
            'product_price' => '45000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Music+Mic+4632231.jpg',
            'exhibitor_id' => '1000',
            'item_category_id' =>'6',
            'condition_id' => '2',
            'product_name' => 'マイク',
            'product_brand' => 'hitachi',
            'product_detail' => '高音質のレコーディング用マイク',
            'product_price' => '8000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Purse+fashion+pocket.jpg',
            'exhibitor_id' => '1000',
            'item_category_id' =>'7',
            'condition_id' => '3',
            'product_name' => 'ショルダーバッグ',
            'product_brand' => 'furla',
            'product_detail' => 'おしゃれなショルダーバッグ',
            'product_price' => '3500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Tumbler+souvenir.jpg',
            'exhibitor_id' => '1000',
            'item_category_id' =>'8',
            'condition_id' => '4',
            'product_name' => 'タンブラー',
            'product_brand' => 'zojirushi',
            'product_detail' => '使いやすいタンブラー',
            'product_price' => '500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Waitress+with+Coffee+Grinder.jpg',
            'exhibitor_id' => '1000',
            'item_category_id' =>'9',
            'condition_id' => '1',
            'product_name' => 'コーヒーミル',
            'product_brand' => 'delonghi',
            'product_detail' => '手動のコーヒーミル',
            'product_price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/外出メイクアップセット.jpg',
            'exhibitor_id' => '1000',
            'item_category_id' =>'10',
            'condition_id' => '2',
            'product_name' => 'メイクセット',
            'product_brand' => 'canmaketokyo',
            'product_detail' => '便利なメイクアップセット',
            'product_price' => '2500',
            
        ];

        DB::table('items')->insert($param);
    }
}