<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'product_id' => 1,
            'category_id' => 1,
        ];
        DB::table('product_category')->insert($param);
        $param = [
            'product_id' => 2,
            'category_id' => 8,
        ];
        DB::table('product_category')->insert($param);
        $param = [
            'product_id' => 3,
            'category_id' => 10,
        ];
        DB::table('product_category')->insert($param);
        $param = [
            'product_id' => 4,
            'category_id' => 1,
        ];
        DB::table('product_category')->insert($param);
        $param = [
            'product_id' => 5,
            'category_id' => 8,
        ];
        DB::table('product_category')->insert($param);
        $param = [
            'product_id' => 6,
            'category_id' => 8,
        ];
        DB::table('product_category')->insert($param);
        $param = [
            'product_id' => 7,
            'category_id' => 1,
        ];
        DB::table('product_category')->insert($param);
        $param = [
            'product_id' => 8,
            'category_id' => 10,
        ];
        DB::table('product_category')->insert($param);
        $param = [
            'product_id' => 9,
            'category_id' => 10,
        ];
        DB::table('product_category')->insert($param);
        $param = [
            'product_id' => 10,
            'category_id' => 6,
        ];
        DB::table('product_category')->insert($param);
        $param = [
            'product_id' => 10,
            'category_id' => 4,
        ];
        DB::table('product_category')->insert($param);
    }
}
