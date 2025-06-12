<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\User;

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
        $users = User::all();

        
        //以下はPro用課題データ
        $param = [
            'image_path' => 'images/Armani+Mens+Clock.jpg',
            'user_id' => 11,
            'condition' => '1',
            'name' => '腕時計',
            'brand' => 'armani',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => '15000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/HDD+Hard+Disk.jpg',
            'user_id' => 11,
            'condition' => '2',
            'name' => 'HDD',
            'brand' => 'toshiba',
            'detail' => '高速で信頼性の高いハードディスク',
            'price' => '5000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/iLoveIMG+d.jpg',
            'user_id' => 11,
            'condition' => '3',
            'name' => '玉ねぎ3束',
            'brand' => 'nagano',
            'detail' => '新鮮な玉ねぎ3束のセット',
            'price' => '300',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Leather+Shoes+Product+Photo.jpg',
            'user_id' => 11,
            'condition' => '4',
            'name' => '革靴',
            'brand' => 'edwin',
            'detail' => 'クラシックなデザインの革靴',
            'price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Living+Room+Laptop.jpg',
            'user_id' => 11,
            'condition' => '1',
            'name' => 'ノートPC',
            'brand' => 'apple',
            'detail' => '高性能なノートパソコン',
            'price' => '45000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Music+Mic+4632231.jpg',
            'user_id' => 12,
            'condition' => '2',
            'name' => 'マイク',
            'brand' => 'hitachi',
            'detail' => '高音質のレコーディング用マイク',
            'price' => '8000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Purse+fashion+pocket.jpg',
            'user_id' => 12,
            'condition' => '3',
            'name' => 'ショルダーバッグ',
            'brand' => 'furla',
            'detail' => 'おしゃれなショルダーバッグ',
            'price' => '3500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Tumbler+souvenir.jpg',
            'user_id' => 12,
            'condition' => '4',
            'name' => 'タンブラー',
            'brand' => 'zojirushi',
            'detail' => '使いやすいタンブラー',
            'price' => '500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Waitress+with+Coffee+Grinder.jpg',
            'user_id' => 12,
            'condition' => '1',
            'name' => 'コーヒーミル',
            'brand' => 'delonghi',
            'detail' => '手動のコーヒーミル',
            'price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/外出メイクアップセット.jpg',
            'user_id' => 12,
            'condition' => '2',
            'name' => 'メイクセット',
            'brand' => 'canmaketokyo',
            'detail' => '便利なメイクアップセット',
            'price' => '2500',
            
        ];

        DB::table('items')->insert($param);
        //ここまでPro用課題データ


        
        $param = [
            'image_path' => 'images/Armani+Mens+Clock.jpg',
            'user_id' => 1,
            'condition' => '1',
            'name' => '腕時計',
            'brand' => 'armani',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => '15000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/HDD+Hard+Disk.jpg',
            'user_id' => 2,
            'condition' => '2',
            'name' => 'HDD',
            'brand' => 'toshiba',
            'detail' => '高速で信頼性の高いハードディスク',
            'price' => '5000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/iLoveIMG+d.jpg',
            'user_id' => 3,
            'condition' => '3',
            'name' => '玉ねぎ3束',
            'brand' => 'nagano',
            'detail' => '新鮮な玉ねぎ3束のセット',
            'price' => '300',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Leather+Shoes+Product+Photo.jpg',
            'user_id' => 4,
            'condition' => '4',
            'name' => '革靴',
            'brand' => 'edwin',
            'detail' => 'クラシックなデザインの革靴',
            'price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Living+Room+Laptop.jpg',
            'user_id' => 5,
            'condition' => '1',
            'name' => 'ノートPC',
            'brand' => 'apple',
            'detail' => '高性能なノートパソコン',
            'price' => '45000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Music+Mic+4632231.jpg',
            'user_id' => 6,
            'condition' => '2',
            'name' => 'マイク',
            'brand' => 'hitachi',
            'detail' => '高音質のレコーディング用マイク',
            'price' => '8000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Purse+fashion+pocket.jpg',
            'user_id' => 7,
            'condition' => '3',
            'name' => 'ショルダーバッグ',
            'brand' => 'furla',
            'detail' => 'おしゃれなショルダーバッグ',
            'price' => '3500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Tumbler+souvenir.jpg',
            'user_id' => 8,
            'condition' => '4',
            'name' => 'タンブラー',
            'brand' => 'zojirushi',
            'detail' => '使いやすいタンブラー',
            'price' => '500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Waitress+with+Coffee+Grinder.jpg',
            'user_id' => 9,
            'condition' => '1',
            'name' => 'コーヒーミル',
            'brand' => 'delonghi',
            'detail' => '手動のコーヒーミル',
            'price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/外出メイクアップセット.jpg',
            'user_id' => 10,
            'condition' => '2',
            'name' => 'メイクセット',
            'brand' => 'canmaketokyo',
            'detail' => '便利なメイクアップセット',
            'price' => '2500',
            
        ];

        DB::table('items')->insert($param);

        
        $param = [
            'image_path' => 'images/Armani+Mens+Clock.jpg',
            'user_id' => 10,
            'condition' => '1',
            'name' => '腕時計',
            'brand' => 'armani',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => '15000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/HDD+Hard+Disk.jpg',
            'user_id' => 9,
            'condition' => '2',
            'name' => 'HDD',
            'brand' => 'toshiba',
            'detail' => '高速で信頼性の高いハードディスク',
            'price' => '5000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/iLoveIMG+d.jpg',
            'user_id' => 8,
            'condition' => '3',
            'name' => '玉ねぎ3束',
            'brand' => 'nagano',
            'detail' => '新鮮な玉ねぎ3束のセット',
            'price' => '300',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Leather+Shoes+Product+Photo.jpg',
            'user_id' => 7,
            'condition' => '4',
            'name' => '革靴',
            'brand' => 'edwin',
            'detail' => 'クラシックなデザインの革靴',
            'price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Living+Room+Laptop.jpg',
            'user_id' => 6,
            'condition' => '1',
            'name' => 'ノートPC',
            'brand' => 'apple',
            'detail' => '高性能なノートパソコン',
            'price' => '45000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Music+Mic+4632231.jpg',
            'user_id' => 5,
            'condition' => '2',
            'name' => 'マイク',
            'brand' => 'hitachi',
            'detail' => '高音質のレコーディング用マイク',
            'price' => '8000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Purse+fashion+pocket.jpg',
            'user_id' => 4,
            'condition' => '3',
            'name' => 'ショルダーバッグ',
            'brand' => 'furla',
            'detail' => 'おしゃれなショルダーバッグ',
            'price' => '3500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Tumbler+souvenir.jpg',
            'user_id' => 3,
            'condition' => '4',
            'name' => 'タンブラー',
            'brand' => 'zojirushi',
            'detail' => '使いやすいタンブラー',
            'price' => '500',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/Waitress+with+Coffee+Grinder.jpg',
            'user_id' => 2,
            'condition' => '1',
            'name' => 'コーヒーミル',
            'brand' => 'delonghi',
            'detail' => '手動のコーヒーミル',
            'price' => '4000',
            
        ];

        DB::table('items')->insert($param);

        $param = [
            'image_path' => 'images/外出メイクアップセット.jpg',
            'user_id' => 1,
            'condition' => '2',
            'name' => 'メイクセット',
            'brand' => 'canmaketokyo',
            'detail' => '便利なメイクアップセット',
            'price' => '2500',
            
        ];

        DB::table('items')->insert($param);
    }
}