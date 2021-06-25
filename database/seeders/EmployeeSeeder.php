<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $employees = [];
        for ($i = 0; $i < 6; $i++) {

            $employees[] = [
                'area_id' => rand(1,4),
                'newsletter' => rand(0,1),
                'name' => $faker->name,
                'email' => $faker->email,
                'sex' => ($i%2 == 0) ? "F" : "M",
                'description' => $faker->text,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];
        }

        $chunks = array_chunk($employees, 10);
        foreach ($chunks as $chunk) {
            Employee::insert($chunk);
        }
    }
}
