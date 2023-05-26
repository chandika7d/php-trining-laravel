<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("sizes")->insert([
          "name" => "XS",
          "order" => "1"
        ]);
        
        \DB::table("sizes")->insert([
          "name" => "S",
          "order" => "2"
        ]);
        
        \DB::table("sizes")->insert([
          "name" => "M",
          "order" => "3"
        ]);

        \DB::table("sizes")->insert([
          "name" => "L",
          "order" => "4"
        ]);
        
        \DB::table("sizes")->insert([
            "name" => "XL",
            "order" => "5"
          ]);
    }
}
