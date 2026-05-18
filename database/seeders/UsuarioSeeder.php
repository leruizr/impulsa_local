<?php

namespace Database\Seeders;

use App\Models\Emprendedor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// Seeder que crea el usuario administrador por defecto y, opcionalmente,
// usuarios de prueba enlazados a los emprendedores ya sembrados.
// Se ejecuta automáticamente desde DatabaseSeeder.
class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador por defecto.
        // Credenciales de acceso inicial: admin@impulsalocal.co / admin1234
        User::updateOrCreate(
            ['email' => 'admin@impulsalocal.co'],
            [
                'name'           => 'Administrador',
                'password'       => Hash::make('admin1234'),
                'rol'            => 'admin',
                'emprendedor_id' => null,
            ]
        );

        // Crea un usuario emprendedor enlazado por email para cada emprendedor sembrado.
        // Esto permite probar el flujo de login como emprendedor sin tener que registrarse.
        // Contraseña inicial para todos: emprendedor1234
        Emprendedor::all()->each(function (Emprendedor $emprendedor) {
            User::updateOrCreate(
                ['email' => $emprendedor->email],
                [
                    'name'           => $emprendedor->nombre,
                    'password'       => Hash::make('emprendedor1234'),
                    'rol'            => 'emprendedor',
                    'emprendedor_id' => $emprendedor->id,
                ]
            );
        });
    }
}
