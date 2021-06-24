<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\EmployeeRole;
use Illuminate\Database\Seeder;

class EmployeeRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $employe_role = [];
        for ($i = 0; $i < 6; $i++) {

            $employe_role[] = [
                'employee_id' => rand(1,6),
                'role_id' => rand(1,6),
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];
        }

        $chunks = array_chunk($employe_role, 10);
        foreach ($chunks as $chunk) {
            EmployeeRole::insert($chunk);
        }
    }
}
