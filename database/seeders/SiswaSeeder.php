<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 100; $i++) {
            DB::table('siswas')->insert([
                'nisn' => $faker->randomNumber(),
                'nama' => $faker->name(),
                'alamat' => $faker->address(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
