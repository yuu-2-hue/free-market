<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '1',
            'name' => '腕時計',
            'image' => 'img/kkrn_icon_user_14.png',
            'post_code' => '123-4567',
            'address' => '東京都港区六本木',
            'building' => 'マンション',
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => '2',
            'name' => 'HDD',
            'image' => 'img/kkrn_icon_user_14.png',
            'post_code' => '123-4567',
            'address' => '東京都港区六本木',
            'building' => 'マンション',
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => '3',
            'name' => 'ほげ',
            'image' => 'img/kkrn_icon_user_14.png',
            'post_code' => '123-4567',
            'address' => '東京都港区六本木',
            'building' => 'マンション',
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => '4',
            'name' => 'ふが',
            'image' => 'img/kkrn_icon_user_14.png',
            'post_code' => '123-4567',
            'address' => '東京都港区六本木',
            'building' => 'マンション',
        ];
        DB::table('profiles')->insert($param);
        $param = [
            'user_id' => '5',
            'name' => 'はが',
            'image' => 'img/kkrn_icon_user_14.png',
            'post_code' => '123-4567',
            'address' => '東京都港区六本木',
            'building' => 'マンション',
        ];
        DB::table('profiles')->insert($param);
    }
}
