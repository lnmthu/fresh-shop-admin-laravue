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
        //
        $category = \App\Laravue\Models\Category::create([
            'name' => 'Tech',
            'description' => 'Technology',
            'sort' => 1
        ]);
    }
}
