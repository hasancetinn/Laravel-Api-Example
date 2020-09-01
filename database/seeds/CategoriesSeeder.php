<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement("TRUNCATE TABLE categories");


        factory(\App\Category::class, 50)->create();

        DB::table('product_categories')->insert([
            'product_id' => 1,
            'category_id' => 1,
        ]);

        DB::table('product_categories')->insert([
            'product_id' => 1,
            'category_id' => 2,
        ]);

        DB::table('product_categories')->insert([
            'product_id' =>2,
            'category_id' => 1,
        ]);

        DB::table('product_categories')->insert([
            'product_id' =>2,
            'category_id' => 2,
        ]);

        DB::table('product_categories')->insert([
            'product_id' =>2,
            'category_id' => 3,
        ]);

//        DB::table('product_categories')->create(['product_id' => 1, 'category_id' => 1]);
//        DB::table('product_categories')->create(['product_id' => 1, 'category_id' => 2]);
//        DB::table('product_categories')->create(['product_id' => 2, 'category_id' => 1]);
//        DB::table('product_categories')->create(['product_id' => 2, 'category_id' => 2]);
//        DB::table('product_categories')->create(['product_id' => 2, 'category_id' => 3]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
