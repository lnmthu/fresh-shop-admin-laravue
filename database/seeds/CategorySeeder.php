<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => "Trái cây",
            'description' => "Các loại trái cây",
            'status' => 1,
            'sku' => 'trctrc',
            'unique_id' => 123,
            'id' => 1,
            "created_at" => date("Y-m-d h:i:s"),

        ]);
        DB::table('categories')->insert([
            'name' => "Nước uống",
            'description' => "Các loại nước uống",
            'status' => 1,
            'sku' => 'nnn',
            'unique_id' => 456,
            'id' => 2,
            "created_at" => date("Y-m-d h:i:s"),

        ]);
        DB::table('categories')->insert([
            'name' => "Thịt",
            'description' => "Các loại thịt",
            'status' => 1,
            'sku' => 'ttt',
            'unique_id' => 789,
            'id' => 3,
            "created_at" => date("Y-m-d h:i:s"),

        ]);
        DB::table('categories')->insert([
            'name' => "Rau",
            'description' => "Các loại rau",
            'status' => 1,
            'sku' => 'rrr',
            'unique_id' => 91011,
            'id' => 4,
            "created_at" => date("Y-m-d h:i:s"),

        ]);
        DB::table('categories')->insert([
            'name' => "Thức ăn nhanh",
            'description' => "Các loại thức ăn nhanh",
            'status' => 1,
            'sku' => 'ccc',
            'unique_id' => 101112,
            'id' => 5,
            "created_at" => date("Y-m-d h:i:s"),

        ]);
    }
}
