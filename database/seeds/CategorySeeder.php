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
        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 2,
        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => Str::random(10),
            'description' => Str::random(100),
            'status' => 1,
        ]);
    }
}
