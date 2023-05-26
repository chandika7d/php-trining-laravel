<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("brands")->insert([
          "name" => "Gucci",
          "slug" => "gucci",
          "description" => "-"
        ]);
        \DB::table("brands")->insert([
          "name" => "Dior",
          "slug" => "dior",
          "description" => "-"
        ]);
        \DB::table("brands")->insert([
          "name" => "Miu Miu",
          "slug" => "miu-miu",
          "description" => "-"
        ]);
        \DB::table("brands")->insert([
          "name" => "Saint Laurent Paris",
          "slug" => "saint-laurent-paris",
          "description" => "-"
        ]);
    }
}
