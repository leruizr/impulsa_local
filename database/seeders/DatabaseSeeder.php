<?php

namespace Database\Seeders;

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
        // Ejecuta los seeders específicos del proyecto en orden.
        // El UsuarioSeeder debe ir AL FINAL porque crea los usuarios
        // emprendedores enlazándose a los emprendedores ya sembrados.
        $this->call([
            EmprendedorSeeder::class,       // Emprendedores de ejemplo
            ProgramaFormacionSeeder::class, // Programas de formación de ejemplo
            UsuarioSeeder::class,           // Admin por defecto + usuarios para cada emprendedor
        ]);
    }
}
