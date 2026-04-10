<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Seeder principal que orquesta la carga inicial de datos en la base de datos.
// Se ejecuta con el comando: php artisan db:seed
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crea un usuario de prueba para poder acceder al sistema
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Ejecuta los seeders específicos del proyecto en orden
        $this->call([
            EmprendedorSeeder::class,       // Carga los emprendedores de ejemplo
            ProgramaFormacionSeeder::class, // Carga los programas de formación de ejemplo
        ]);
    }
}
