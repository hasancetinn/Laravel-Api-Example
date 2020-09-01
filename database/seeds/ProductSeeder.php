<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement("TRUNCATE TABLE products");

        factory(\App\Product::class,50)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
