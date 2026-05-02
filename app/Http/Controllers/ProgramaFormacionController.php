<?php

namespace App\Http\Controllers;

use App\Models\ProgramaFormacion;
use Illuminate\Http\Request;

// Controlador que gestiona todas las operaciones CRUD de los programas de formación.
// Cada accion lee o escribe directamente en la tabla 'programas_formacion' de la base de datos.
class ProgramaFormacionController extends Controller
{
    // Obtiene todos los programas de la base de datos y los muestra en el listado.
    // Corresponde a la ruta GET /programas
    public function index()
    {
        $programas = ProgramaFormacion::all();
        return view('programas.index', compact('programas'));
    }

    // Muestra el formulario para registrar un nuevo programa de formación.
    // Corresponde a la ruta GET /programas/create
    public function create()
    {
        return view('programas.create');
    }

    // Valida los datos del formulario y guarda el nuevo programa en la base de datos.
    // Corresponde a la ruta POST /programas
    public function store(Request $request)
    {
        // Valida que cada campo cumpla con el formato y valores permitidos
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'cupo_maximo' => 'required|integer|min:1',
            'estado'      => 'required|in:activo,inactivo',
        ]);

        // Crea y guarda el programa en la base de datos con los datos del formulario
        ProgramaFormacion::create($request->only([
            'nombre', 'descripcion', 'cupo_maximo', 'estado'
        ]));

        return redirect()->route('programas.index')
            ->with('success', 'Programa de formación creado exitosamente.');
    }

    // Busca el programa en la base de datos y muestra el formulario con sus datos actuales.
    // Corresponde a la ruta GET /programas/{id}/edit
    public function edit($id)
    {
        // findOrFail lanza un error 404 automaticamente si el ID no existe
        $programa = ProgramaFormacion::findOrFail($id);
        return view('programas.edit', compact('programa'));
    }

    // Valida los datos del formulario y actualiza el programa en la base de datos.
    // Corresponde a la ruta PUT /programas/{id}
    public function update(Request $request, $id)
    {
        // Aplica las mismas reglas de validacion que en el registro
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'cupo_maximo' => 'required|integer|min:1',
            'estado'      => 'required|in:activo,inactivo',
        ]);

        // Busca el programa y actualiza sus datos en la base de datos
        $programa = ProgramaFormacion::findOrFail($id);
        $programa->update($request->only([
            'nombre', 'descripcion', 'cupo_maximo', 'estado'
        ]));

        return redirect()->route('programas.index')
            ->with('success', 'Programa de formación actualizado exitosamente.');
    }

    // Elimina el programa de la base de datos.
    // Corresponde a la ruta DELETE /programas/{id}
    public function destroy($id)
    {
        // Busca el programa y lo elimina permanentemente de la base de datos
        $programa = ProgramaFormacion::findOrFail($id);
        $programa->delete();

        return redirect()->route('programas.index')
            ->with('success', 'Programa de formación eliminado exitosamente.');
    }
}
