<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Deseo recibir boletín informativo',
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        Role::create([
            'name' => 'Profesional de Proyectos - Desarrollador',
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);        
        
        Role::create([
            'name' => 'Gerente Estratégico',
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

        Role::create([
            'name' => 'Auxiliar Administrativo',
            'created_at' => now()->toDateString(),
            'updated_at' => now()->toDateString()
        ]);

    }
}
