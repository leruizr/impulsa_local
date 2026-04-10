<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Controlador que gestiona todas las operaciones CRUD de los emprendedores.
// Por ahora trabaja con datos en memoria (sin base de datos) para propósitos de desarrollo.
class EmprendedorController extends Controller
{
    // Retorna una colección de emprendedores de ejemplo (datos estáticos en memoria).
    // Esta función simula lo que luego será una consulta real a la base de datos.
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

    // Muestra la lista de todos los emprendedores registrados.
    // Corresponde a la ruta GET /emprendedores
    public function index()
    {
        $emprendedores = $this->getEmprendedores();
        return view('emprendedores.index', compact('emprendedores'));
    }

    // Muestra el formulario para registrar un nuevo emprendedor.
    // Corresponde a la ruta GET /emprendedores/create
    public function create()
    {
        return view('emprendedores.create');
    }

    // Recibe y valida los datos del formulario de creación, luego redirige al listado.
    // Corresponde a la ruta POST /emprendedores
    public function store(Request $request)
    {
        // Valida que cada campo cumpla con el formato y valores permitidos
        $request->validate([
            'nombre'              => 'required|string|max:255',
            'actividad_economica' => 'required|in:artesano,panadería,taller,tienda,otro',
            'ubicacion'           => 'required|string|max:255',
            'telefono'            => 'required|string|max:20',
            'email'               => 'required|email|max:255',
            'estado'              => 'required|in:activo,inactivo',
        ]);

        // Redirige al listado con un mensaje de éxito (aún no persiste en BD)
        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor registrado exitosamente.');
    }

    // Muestra el formulario de edición con los datos actuales del emprendedor.
    // Corresponde a la ruta GET /emprendedores/{id}/edit
    public function edit($id)
    {
        // Busca el emprendedor por su ID en la colección en memoria
        $emprendedor = $this->getEmprendedores()->firstWhere('id', (int) $id);

        // Si no se encuentra el ID, redirige al listado sin mostrar error
        if (!$emprendedor) {
            return redirect()->route('emprendedores.index');
        }

        return view('emprendedores.edit', compact('emprendedor'));
    }

    // Recibe y valida los datos del formulario de edición, luego redirige al listado.
    // Corresponde a la ruta PUT /emprendedores/{id}
    public function update(Request $request, $id)
    {
        // Aplica las mismas reglas de validación que en el registro
        $request->validate([
            'nombre'              => 'required|string|max:255',
            'actividad_economica' => 'required|in:artesano,panadería,taller,tienda,otro',
            'ubicacion'           => 'required|string|max:255',
            'telefono'            => 'required|string|max:20',
            'email'               => 'required|email|max:255',
            'estado'              => 'required|in:activo,inactivo',
        ]);

        // Redirige al listado con mensaje de éxito (aún no actualiza en BD)
        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor actualizado exitosamente.');
    }

    // Elimina un emprendedor y redirige al listado.
    // Corresponde a la ruta DELETE /emprendedores/{id}
    public function destroy($id)
    {
        // Redirige al listado con mensaje de éxito (aún no elimina en BD)
        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor eliminado exitosamente.');
    }
}
