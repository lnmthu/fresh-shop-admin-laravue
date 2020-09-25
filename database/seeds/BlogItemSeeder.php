<?php

use Illuminate\Database\Seeder;
use App\Laravue\Models\BlogItem;

class BlogItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BlogItem::class, 15)->create();
    }
}
