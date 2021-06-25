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
        Area::create([
            'name' => 'Administracion',
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        Area::create([
            'name' => 'Ventas',
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        Area::create([
            'name' => 'Calidad',
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        Area::create([
            'name' => 'Produccion',
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);
    }
}
