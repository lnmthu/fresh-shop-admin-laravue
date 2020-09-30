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
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            'parent_id' => 3,

        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 2,
            'unique_id' => rand(1000000,5000000),
            'parent_id' => 5,

        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            'parent_id' => 4,

        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            'parent_id' => 3,

        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            'parent_id' => 2,

        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            'parent_id' => 1,

        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            'parent_id' => 5,

        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            'parent_id' => 4,

        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            'parent_id' => 3,

        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
            'unique_id' => rand(1000000,5000000),
            'parent_id' => 2,

        ]);
    }
}
