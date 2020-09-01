<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("TRUNCATE TABLE users");


        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@laravel.com',
            'email_verified_at' => now(),
            'password' => bcrypt(123123123),
            'remember_token' => Str::random(10),
            'api_token' => Str::random(60)
        ]);

        factory(\App\User::class,10)->create();
    }
}
