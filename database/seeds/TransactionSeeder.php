<?php

use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\Laravue\Models\Transaction::class, 10)->create();
        $products = App\Laravue\Models\Product::all();

        App\Laravue\Models\Order::all()->each(function ($order) use ($products) {
            $products->random(rand(1, 3))->each(function ($item) use ($order) {
                $order->products()->attach([
                    $item->id => [
                        'qty' => 1,
                        'price' => $item->price,
                        'product_name' => $item->name,
                        'product_sku' => $item->sku,
                        'product_description' => $item->description,
                    ]
                ]);
            });
        });
    }
}
