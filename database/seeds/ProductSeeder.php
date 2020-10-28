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
            'name' => "Thịt bò",
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 100000,
            'qty' => 10,
            'category_unique_id' => 789,
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            "created_at" => date("Y-m-d h:i:sa"),

        ]);
        DB::table('products')->insert([
            'name' => "Cải xà lách",
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 110000,
            'qty' => 11,
            'category_unique_id' => 91011,
            'unique_id' => rand(1000000,5000000),
            'status' => 1,
            "created_at" => date("Y-m-d h:i:sa"),

        ]);
        DB::table('products')->insert([
            'name' => "Chuối",
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 200000,
            'qty' => 20,
            'category_unique_id' => 123,
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            "created_at" => date("Y-m-d h:i:sa"),

        ]);
        DB::table('products')->insert([
            'name' => "Bnatural",
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 220000,
            'qty' => 22,
            'category_unique_id' => 456,
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            "created_at" => date("Y-m-d h:i:sa"),


        ]);
        DB::table('products')->insert([
            'name' =>"Đùi gà chiên",
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 300000,
            'qty' => 30,
            'category_unique_id' => 101112,
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            "created_at" => date("Y-m-d h:i:sa"),


        ]);
        DB::table('products')->insert([
            'name' => "Dưa hấu",
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 330000,
            'qty' => 33,
            'category_unique_id' => 123,
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            "created_at" => date("Y-m-d h:i:sa"),

        ]);
        DB::table('products')->insert([
            'name' => "Thịt heo",
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 330000,
            'qty' => 33,
            'category_unique_id' => 789,
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            "created_at" => date("Y-m-d h:i:sa"),

        ]);
        DB::table('products')->insert([
            'name' => "Cà chua",
            'sku' => Str::random(5),
            'description' => Str::random(20),
            'price' => 330000,
            'qty' => 33,
            'category_unique_id' => 91011,
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            "created_at" => date("Y-m-d h:i:sa"),

        ]);
        
    }

}
