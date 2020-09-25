<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\BlogItem;
use App\Laravue\Models\BlogCategory;
use App\Laravue\Models\User;
use Faker\Generator as Faker;

$factory->define(BlogItem::class, function (Faker $faker) {

    $users = User::pluck('id')->toArray();
    $categories = BlogCategory::pluck('id')->toArray();

    return [
        'title' =>$faker->unique()->sentence(rand(1, 2)),
        'description' => $faker->paragraph(rand(1, 3)),
        'body' => $faker->paragraph(rand(3, 10)),
        'sort' => rand(0, 4),
        'status' => rand(0, 1),
        'blog_category_id' => $faker->randomElement($categories),
        'user_id' => $faker->randomElement($users),
    ];
});
