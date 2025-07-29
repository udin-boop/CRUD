<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Faker\Factory as Faker;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            $tahun = $faker->numberBetween(1950, 2023);
            $tanggal = $faker->dateTimeBetween("$tahun-01-01", "$tahun-12-31");

            Brand::create([
                'nama' => $faker->company,
                'negara_asal' => $faker->country,
                'tahun_berdiri' => $tahun,
                'tanggal_berdiri' => $tanggal->format('Y-m-d'),
            ]);
        }
    }
}
