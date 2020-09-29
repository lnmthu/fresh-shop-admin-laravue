<?php

use Illuminate\Database\Seeder;
use App\Laravue\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BlogCategory::class, 10)->create();
    }
}
