<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OcassionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("ocassions")->insert([
            "name" => "Maternity",
        ]);

        \DB::table("ocassions")->insert([
            "name" => "Bridal",
        ]);

        \DB::table("ocassions")->insert([
            "name" => "Evening",
        ]);

        \DB::table("ocassions")->insert([
            "name" => "Prewedding",
        ]);

        \DB::table("ocassions")->insert([
            "name" => "Wedding",
        ]);
    }
}