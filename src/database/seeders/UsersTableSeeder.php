<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::factory()->count(5)->create();
        $param = [
            'name' => '長谷川',
            'email' => 'hasegawa@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '山本',
            'email' => 'yamamoto@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('yamamoto'),
            'remember_token' => Str::random(10),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '中川',
            'email' => 'nakagawa@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('nakagawa'),
            'remember_token' => Str::random(10),
        ];
        DB::table('users')->insert($param);
    }
}
