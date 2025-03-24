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
            'exhibitor_id' => '2',
            //'item_category_id' =>'1',
            //'condition_id' => '1',
            'condition' => '1',
            'item_name' => '腕時計',
            'item_brand' => 'armani',
            'item_detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'item_price' => '15000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/HDD+Hard+Disk.jpg',
            'exhibitor_id' => '5',
            //'item_category_id' =>'2',
            //'condition_id' => '2',
            'condition' => '2',
            'item_name' => 'HDD',
            'item_brand' => 'toshiba',
            'item_detail' => '高速で信頼性の高いハードディスク',
            'item_price' => '5000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/iLoveIMG+d.jpg',
            'exhibitor_id' => '1',
            //'item_category_id' =>'3',
            //'condition_id' => '3',
            'condition' => '3',
            'item_name' => '玉ねぎ3束',
            'item_brand' => 'nagano',
            'item_detail' => '新鮮な玉ねぎ3束のセット',
            'item_price' => '300',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Leather+Shoes+Product+Photo.jpg',
            'exhibitor_id' => '8',
            //'item_category_id' =>'4',
            //'condition_id' => '4',
            'condition' => '4',
            'item_name' => '革靴',
            'item_brand' => 'edwin',
            'item_detail' => 'クラシックなデザインの革靴',
            'item_price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Living+Room+Laptop.jpg',
            'exhibitor_id' => '7',
            //'item_category_id' =>'5',
            //'condition_id' => '1',
            'condition' => '1',
            'item_name' => 'ノートPC',
            'item_brand' => 'apple',
            'item_detail' => '高性能なノートパソコン',
            'item_price' => '45000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Music+Mic+4632231.jpg',
            'exhibitor_id' => '6',
            //'item_category_id' =>'6',
            //'condition_id' => '2',
            'condition' => '2',
            'item_name' => 'マイク',
            'item_brand' => 'hitachi',
            'item_detail' => '高音質のレコーディング用マイク',
            'item_price' => '8000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Purse+fashion+pocket.jpg',
            'exhibitor_id' => '6',
            //'item_category_id' =>'7',
            //'condition_id' => '3',
            'condition' => '3',
            'item_name' => 'ショルダーバッグ',
            'item_brand' => 'furla',
            'item_detail' => 'おしゃれなショルダーバッグ',
            'item_price' => '3500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Tumbler+souvenir.jpg',
            'exhibitor_id' => '6',
            //'item_category_id' =>'8',
            //'condition_id' => '4',
            'condition' => '4',
            'item_name' => 'タンブラー',
            'item_brand' => 'zojirushi',
            'item_detail' => '使いやすいタンブラー',
            'item_price' => '500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Waitress+with+Coffee+Grinder.jpg',
            'exhibitor_id' => '10',
            //'item_category_id' =>'9',
            //'condition_id' => '1',
            'condition' => '1',
            'item_name' => 'コーヒーミル',
            'item_brand' => 'delonghi',
            'item_detail' => '手動のコーヒーミル',
            'item_price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/外出メイクアップセット.jpg',
            'exhibitor_id' => '9',
            //'item_category_id' =>'10',
            //'condition_id' => '2',
            'condition' => '2',
            'item_name' => 'メイクセット',
            'item_brand' => 'canmaketokyo',
            'item_detail' => '便利なメイクアップセット',
            'item_price' => '2500',
            
        ];

        DB::table('items')->insert($param);

        //2週目(お気に入り情報など格納する用)
        
        $param = [
            'item_image_path' => 'images/Armani+Mens+Clock.jpg',
            'exhibitor_id' => '8',
            //'item_category_id' =>'1',
            //'condition_id' => '1',
            'condition' => '1',
            'item_name' => '腕時計',
            'item_brand' => 'armani',
            'item_detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'item_price' => '15000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/HDD+Hard+Disk.jpg',
            'exhibitor_id' => '2',
            //'item_category_id' =>'2',
            //'condition_id' => '2',
            'condition' => '2',
            'item_name' => 'HDD',
            'item_brand' => 'toshiba',
            'item_detail' => '高速で信頼性の高いハードディスク',
            'item_price' => '5000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/iLoveIMG+d.jpg',
            'exhibitor_id' => '1',
            //'item_category_id' =>'3',
            //'condition_id' => '3',
            'condition' => '3',
            'item_name' => '玉ねぎ3束',
            'item_brand' => 'nagano',
            'item_detail' => '新鮮な玉ねぎ3束のセット',
            'item_price' => '300',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Leather+Shoes+Product+Photo.jpg',
            'exhibitor_id' => '3',
            //'item_category_id' =>'4',
            //'condition_id' => '4',
            'condition' => '4',
            'item_name' => '革靴',
            'item_brand' => 'edwin',
            'item_detail' => 'クラシックなデザインの革靴',
            'item_price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Living+Room+Laptop.jpg',
            'exhibitor_id' => '4',
            //'item_category_id' =>'5',
            //'condition_id' => '1',
            'condition' => '1',
            'item_name' => 'ノートPC',
            'item_brand' => 'apple',
            'item_detail' => '高性能なノートパソコン',
            'item_price' => '45000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Music+Mic+4632231.jpg',
            'exhibitor_id' => '1',
            //'item_category_id' =>'6',
            //'condition_id' => '2',
            'condition' => '2',
            'item_name' => 'マイク',
            'item_brand' => 'hitachi',
            'item_detail' => '高音質のレコーディング用マイク',
            'item_price' => '8000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Purse+fashion+pocket.jpg',
            'exhibitor_id' => '8',
            //'item_category_id' =>'7',
            //'condition_id' => '3',
            'condition' => '3',
            'item_name' => 'ショルダーバッグ',
            'item_brand' => 'furla',
            'item_detail' => 'おしゃれなショルダーバッグ',
            'item_price' => '3500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Tumbler+souvenir.jpg',
            'exhibitor_id' => '5',
            //'item_category_id' =>'8',
            //'condition_id' => '4',
            'condition' => '4',
            'item_name' => 'タンブラー',
            'item_brand' => 'zojirushi',
            'item_detail' => '使いやすいタンブラー',
            'item_price' => '500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/Waitress+with+Coffee+Grinder.jpg',
            'exhibitor_id' => '4',
            //'item_category_id' =>'9',
            //'condition_id' => '1',
            'condition' => '1',
            'item_name' => 'コーヒーミル',
            'item_brand' => 'delonghi',
            'item_detail' => '手動のコーヒーミル',
            'item_price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'item_image_path' => 'images/外出メイクアップセット.jpg',
            'exhibitor_id' => '7',
            //'item_category_id' =>'10',
            //'condition_id' => '2',
            'condition' => '2',
            'item_name' => 'メイクセット',
            'item_brand' => 'canmaketokyo',
            'item_detail' => '便利なメイクアップセット',
            'item_price' => '2500',
            
        ];

        DB::table('items')->insert($param);
    }
}