<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => Str::random(10),
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 100000,
            'qty' => 10,
            'category_id' => 1,
            'status' => 1,

        ]);
        DB::table('products')->insert([
            'name' => Str::random(10),
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 110000,
            'qty' => 11,
            'category_id' => 1,
            'status' => 1,
        ]);
        DB::table('products')->insert([
            'name' => Str::random(10),
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 200000,
            'qty' => 20,
            'category_id' => 2,
            'status' => 2,
        ]);
        DB::table('products')->insert([
            'name' => Str::random(10),
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 220000,
            'qty' => 22,
            'category_id' => 2,
            'status' => 2,

        ]);
        DB::table('products')->insert([
            'name' => Str::random(10),
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 300000,
            'qty' => 30,
            'category_id' => 1,
            'status' => 1,

        ]);
        DB::table('products')->insert([
            'name' => Str::random(10),
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 330000,
            'qty' => 33,
            'category_id' => 3,
            'status' => 2,
        ]);
    }
}
