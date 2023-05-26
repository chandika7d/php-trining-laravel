<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CuttingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("cuttings")->insert([
          "name" => "Upper",
        ]);
        
        \DB::table("cuttings")->insert([
          "name" => "Lower",
        ]);
    }
}
