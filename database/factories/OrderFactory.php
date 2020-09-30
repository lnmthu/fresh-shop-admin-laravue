<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\Order;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Order::class, function (Faker $faker) {
    $users = App\Laravue\Models\User::pluck('id')->toArray();
    return [
        'unique_id' => mt_rand(10000000, 99999999),
        'code' => '#GOSHOPP-' . Str::random(5) . sha1(time()),
        'user_id' => $faker->randomElement($users),
        'total_price' => $faker->numberBetween($min = 1500, $max = 6000),
        'sub_total' => $faker->numberBetween($min = 1500, $max = 6000),
        'shipping_fee' => $faker->numberBetween($min = 1500, $max = 6000),
        'shipping_address' => $faker->address,
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone_number' => $faker->phoneNumber,
    ];
});
