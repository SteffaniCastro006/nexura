<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $areas = [];
        for ($i = 0; $i < 6; $i++) {

            $areas[] = [
                'name' => $faker->name,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];
        }

        $chunks = array_chunk($areas, 10);
        foreach ($chunks as $chunk) {
            Area::insert($chunk);
        }
    }
}
