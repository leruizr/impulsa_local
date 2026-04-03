<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmprendedorController extends Controller
{
    private function getEmprendedores()
    {
        return collect([
            (object) [
                'id' => 1,
                'nombre' => 'María del Carmen López',
                'actividad_economica' => 'artesano',
                'ubicacion' => 'Barrio San José, Calle 12 #4-56',
                'telefono' => '3101234567',
                'email' => 'maria.lopez@correo.com',
                'estado' => 'activo',
            ],
            (object) [
                'id' => 2,
                'nombre' => 'José Hernando Ramírez',
                'actividad_economica' => 'panadería',
                'ubicacion' => 'Barrio El Centro, Carrera 7 #10-23',
                'telefono' => '3209876543',
                'email' => 'jose.ramirez@correo.com',
                'estado' => 'activo',
            ],
            (object) [
                'id' => 3,
                'nombre' => 'Luz Dary Moreno',
                'actividad_economica' => 'tienda',
                'ubicacion' => 'Barrio La Esperanza, Calle 5 #8-12',
                'telefono' => '3156789012',
                'email' => 'luz.moreno@correo.com',
                'estado' => 'activo',
            ],
            (object) [
                'id' => 4,
                'nombre' => 'Carlos Andrés Patiño',
                'actividad_economica' => 'taller',
                'ubicacion' => 'Barrio Las Flores, Carrera 3 #15-40',
                'telefono' => '3184567890',
                'email' => 'carlos.patino@correo.com',
                'estado' => 'inactivo',
            ],
            (object) [
                'id' => 5,
                'nombre' => 'Ana Milena Torres',
                'actividad_economica' => 'otro',
                'ubicacion' => 'Barrio Nuevo Horizonte, Calle 20 #6-78',
                'telefono' => '3001122334',
                'email' => 'ana.torres@correo.com',
                'estado' => 'activo',
            ],
        ]);
    }

    public function index()
    {
        $emprendedores = $this->getEmprendedores();
        return view('emprendedores.index', compact('emprendedores'));
    }

    public function create()
    {
        return view('emprendedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'actividad_economica' => 'required|in:artesano,panadería,taller,tienda,otro',
            'ubicacion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor registrado exitosamente.');
    }

    public function edit($id)
    {
        $emprendedor = $this->getEmprendedores()->firstWhere('id', (int) $id);

        if (!$emprendedor) {
            return redirect()->route('emprendedores.index');
        }

        return view('emprendedores.edit', compact('emprendedor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'actividad_economica' => 'required|in:artesano,panadería,taller,tienda,otro',
            'ubicacion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'estado' => 'required|in:activo,inactivo',
        ]);

        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor actualizado exitosamente.');
    }

    public function destroy($id)
    {
        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor eliminado exitosamente.');
    }
}
