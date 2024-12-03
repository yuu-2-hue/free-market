<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'condition_id' => '1',
            'name' => '腕時計',
            'brand' => 'ブランド',
            'image' => 'img/Armani+Mens+Clock.jpg',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => '15000',
            'buy' => '1',
            'sell' => '7',
        ];
        DB::table('products')->insert($param);
        $param = [
            'condition_id' => '2',
            'name' => 'HDD',
            'brand' => 'ブランド',
            'image' => 'img/HDD+Hard+Disk.jpg',
            'detail' => '高速で信頼性の高いハードディスク',
            'price' => '5000',
            'buy' => '0',
            'sell' => '3',
        ];
        DB::table('products')->insert($param);
        $param = [
            'condition_id' => '3',
            'name' => '玉ねぎ3束',
            'brand' => 'ブランド',
            'image' => 'img/iLoveIMG+d.jpg',
            'detail' => '新鮮な玉ねぎ3束のセット',
            'price' => '300',
            'buy' => '0',
            'sell' => '4',
        ];
        DB::table('products')->insert($param);
        $param = [
            'condition_id' => '4',
            'name' => '革靴',
            'brand' => 'ブランド',
            'image' => 'img/Leather+Shoes+Product+Photo.jpg',
            'detail' => 'クラシックなデザインの革靴',
            'price' => '4000',
            'buy' => '0',
            'sell' => '4',
        ];
        DB::table('products')->insert($param);
        $param = [
            'condition_id' => '1',
            'name' => 'ノートPC',
            'brand' => 'ブランド',
            'image' => 'img/Living+Room+Laptop.jpg',
            'detail' => '高性能なノートパソコン',
            'price' => '45000',
            'buy' => '0',
            'sell' => '7',
        ];
        DB::table('products')->insert($param);
        $param = [
            'condition_id' => '2',
            'name' => 'マイク',
            'brand' => 'ブランド',
            'image' => 'img/Music+Mic+4632231.jpg',
            'detail' => '高音質のレコーディング用マイク',
            'price' => '8000',
            'buy' => '0',
            'sell' => '7',
        ];
        DB::table('products')->insert($param);
        $param = [
            'condition_id' => '3',
            'name' => 'ショルダーバッグ',
            'brand' => 'ブランド',
            'image' => 'img/Purse+fashion+pocket.jpg',
            'detail' => 'おしゃれなショルダーバッグ',
            'price' => '3500',
            'buy' => '0',
            'sell' => '5',
        ];
        DB::table('products')->insert($param);
        $param = [
            'condition_id' => '4',
            'name' => 'タンブラー',
            'brand' => 'ブランド',
            'image' => 'img/Tumbler+souvenir.jpg',
            'detail' => '使いやすいタンブラー',
            'price' => '500',
            'buy' => '0',
            'sell' => '7',
        ];
        DB::table('products')->insert($param);
        $param = [
            'condition_id' => '1',
            'name' => 'コーヒーミル',
            'brand' => 'ブランド',
            'image' => 'img/Waitress+with+Coffee+Grinder.jpg',
            'detail' => '手動のコーヒーミル',
            'price' => '4000',
            'buy' => '0',
            'sell' => '9',
        ];
        DB::table('products')->insert($param);
        $param = [
            'condition_id' => '2',
            'name' => 'メイクセット',
            'brand' => 'ブランド',
            'image' => 'img/MakeupSet.jpg',
            'detail' => '便利なメイクアップセット',
            'price' => '2500',
            'buy' => '0',
            'sell' => '1',
        ];
        DB::table('products')->insert($param);
    }
}
