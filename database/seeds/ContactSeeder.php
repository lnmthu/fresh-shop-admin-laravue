<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<4;$i++)
            DB::table("contact")->insert([
                "name"=> Str::random(10),
                "email"=>Str::random(10)."@gmail.com",
                "message"=>Str::random(100),
                "unique_id" => rand(100,200),
                "status" => rand(0,1),
            ]);

    }
}
