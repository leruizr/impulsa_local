<?php

namespace Database\Seeders;

use App\Models\ProgramaFormacion;
use Illuminate\Database\Seeder;

// Seeder que inserta programas de formación de ejemplo en la base de datos.
// Útil para tener datos iniciales al desarrollar y probar la aplicación.
// Se ejecuta automáticamente desde DatabaseSeeder.
class ProgramaFormacionSeeder extends Seeder
{
    public function run(): void
    {
        // Arreglo con los programas de formación de ejemplo
        $programas = [
            [
                'nombre'      => 'Marketing Digital',
                'descripcion' => 'Aprende a promocionar tu negocio en redes sociales y plataformas digitales para llegar a más clientes.',
            ],
            [
                'nombre'      => 'Comercio Digital',
                'descripcion' => 'Herramientas y estrategias para vender tus productos y servicios por internet de forma efectiva.',
            ],
            [
                'nombre'      => 'Contabilidad Básica',
                'descripcion' => 'Fundamentos de contabilidad para llevar las cuentas de tu negocio de manera organizada y cumplir con las obligaciones tributarias.',
            ],
            [
                'nombre'      => 'Gestión Empresarial',
                'descripcion' => 'Desarrollo de habilidades administrativas para planificar, organizar y dirigir tu emprendimiento con éxito.',
            ],
        ];

        // Recorre el arreglo e inserta cada programa en la base de datos
        foreach ($programas as $programa) {
            ProgramaFormacion::create($programa);
        }
    }
}
