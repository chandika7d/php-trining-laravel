<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("colors")->insert([
          "name" => "Navy",
          "hex" => "1b2d56",
        ]);

        \DB::table("colors")->insert([
          "name" => "Pink",
          "hex" => "f9cccc",
        ]);

        \DB::table("colors")->insert([
          "name" => "White",
          "hex" => "aaaaaa",
        ]);
    }
}
