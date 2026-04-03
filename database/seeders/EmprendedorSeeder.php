<?php

namespace Database\Seeders;

use App\Models\Emprendedor;
use Illuminate\Database\Seeder;

class EmprendedorSeeder extends Seeder
{
    public function run(): void
    {
        $emprendedores = [
            [
                'nombre' => 'María del Carmen López',
                'actividad_economica' => 'artesano',
                'ubicacion' => 'Barrio San José, Calle 12 #4-56',
                'telefono' => '3101234567',
                'email' => 'maria.lopez@correo.com',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'José Hernando Ramírez',
                'actividad_economica' => 'panadería',
                'ubicacion' => 'Barrio El Centro, Carrera 7 #10-23',
                'telefono' => '3209876543',
                'email' => 'jose.ramirez@correo.com',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Luz Dary Moreno',
                'actividad_economica' => 'tienda',
                'ubicacion' => 'Barrio La Esperanza, Calle 5 #8-12',
                'telefono' => '3156789012',
                'email' => 'luz.moreno@correo.com',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Carlos Andrés Patiño',
                'actividad_economica' => 'taller',
                'ubicacion' => 'Barrio Las Flores, Carrera 3 #15-40',
                'telefono' => '3184567890',
                'email' => 'carlos.patino@correo.com',
                'estado' => 'inactivo',
            ],
            [
                'nombre' => 'Ana Milena Torres',
                'actividad_economica' => 'otro',
                'ubicacion' => 'Barrio Nuevo Horizonte, Calle 20 #6-78',
                'telefono' => '3001122334',
                'email' => 'ana.torres@correo.com',
                'estado' => 'activo',
            ],
        ];

        foreach ($emprendedores as $emprendedor) {
            Emprendedor::create($emprendedor);
        }
    }
}
