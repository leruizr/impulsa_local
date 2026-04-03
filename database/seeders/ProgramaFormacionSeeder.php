<?php

namespace Database\Seeders;

use App\Models\ProgramaFormacion;
use Illuminate\Database\Seeder;

class ProgramaFormacionSeeder extends Seeder
{
    public function run(): void
    {
        $programas = [
            [
                'nombre' => 'Marketing Digital',
                'descripcion' => 'Aprende a promocionar tu negocio en redes sociales y plataformas digitales para llegar a más clientes.',
            ],
            [
                'nombre' => 'Comercio Digital',
                'descripcion' => 'Herramientas y estrategias para vender tus productos y servicios por internet de forma efectiva.',
            ],
            [
                'nombre' => 'Contabilidad Básica',
                'descripcion' => 'Fundamentos de contabilidad para llevar las cuentas de tu negocio de manera organizada y cumplir con las obligaciones tributarias.',
            ],
            [
                'nombre' => 'Gestión Empresarial',
                'descripcion' => 'Desarrollo de habilidades administrativas para planificar, organizar y dirigir tu emprendimiento con éxito.',
            ],
        ];

        foreach ($programas as $programa) {
            ProgramaFormacion::create($programa);
        }
    }
}
