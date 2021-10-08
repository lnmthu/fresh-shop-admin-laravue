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
        DB::table('blog_categories')->insert([
            ['title' => "Thức ăn",'description' => "Các loại thức ăn",'sort'=>0],
            ['title' => "Trái cây",'description' => "Các loại trái cây",'sort'=>0],
            ['title' => "Nước uống",'description' => "Các loại nước uống",'sort'=>0]
        ]);
    }
}
