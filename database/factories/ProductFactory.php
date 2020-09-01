<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    $product_name = $faker->sentence(3);

    return [
        'name' => $product_name,
        'slug' => Str::slug($product_name),
        'description' => $faker->paragraph(5),
        'price' => mt_rand(10,100)/10,

    ];
});
