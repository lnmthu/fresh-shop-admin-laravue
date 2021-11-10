<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'sku' => $faker->word(),
        'description' => $faker->text,
        'price' => $faker->randomNumber(2),
        'qty' => 50,
        'category_id' => 1,
        'sort' => 1,
    ];
});
