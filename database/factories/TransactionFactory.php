<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\Order;
use App\Laravue\Models\Transaction;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Transaction::class, function (Faker $faker) use ($factory) {
    $order = factory(Order::class)->create();
    return [
        'code' => $order->code,
        'order_id' => $order->id,
        'total_price' => $order->total_price,
        'sub_total' => $order->sub_total,
        'payment_code' => '#' . Str::random(5) . sha1(time()),
    ];
});
