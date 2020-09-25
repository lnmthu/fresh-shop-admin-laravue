<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\BlogCategory;
use Faker\Generator as Faker;

$factory->define(BlogCategory::class, function (Faker $faker) {
    return [
        'title' =>$faker->unique()->sentence(rand(1, 2)),
        'description' => $faker->paragraph(rand(1, 3)),
        'sort' => rand(0, 4),
    ];
});
