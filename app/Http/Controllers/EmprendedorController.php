<?php

namespace App\Http\Controllers;

use App\Models\Emprendedor;
use App\Models\ProgramaFormacion;
use Illuminate\Http\Request;

// Controlador que gestiona todas las operaciones CRUD de los emprendedores.
// Cada accion lee o escribe directamente en la tabla 'emprendedores' de la base de datos.
class EmprendedorController extends Controller
{
    // Obtiene todos los emprendedores de la base de datos y los muestra en el listado.
    // Corresponde a la ruta GET /emprendedores
    public function index()
    {
        $emprendedores = Emprendedor::all();
        return view('emprendedores.index', compact('emprendedores'));
    }

    // Muestra el formulario para registrar un nuevo emprendedor.
    // Corresponde a la ruta GET /emprendedores/create
    public function create()
    {
        return view('emprendedores.create');
    }

    // Valida los datos del formulario y guarda el nuevo emprendedor en la base de datos.
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

        // Crea y guarda el emprendedor en la base de datos con los datos del formulario
        Emprendedor::create($request->only([
            'nombre', 'actividad_economica', 'ubicacion', 'telefono', 'email', 'estado'
        ]));

        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor registrado exitosamente.');
    }

    // Muestra el detalle del emprendedor con sus programas inscritos
    // y el formulario para inscribirlo en un programa nuevo.
    // Corresponde a la ruta GET /emprendedores/{id}
    public function show($id)
    {
        // Carga el emprendedor junto con sus programas inscritos en una sola consulta
        $emprendedor = Emprendedor::with('programasFormacion')->findOrFail($id);

        // Lista los IDs de los programas en los que ya está inscrito
        $programasInscritosIds = $emprendedor->programasFormacion->pluck('id');

        // Trae solo los programas activos donde el emprendedor aun no esta inscrito
        $programasDisponibles = ProgramaFormacion::where('estado', 'activo')
            ->whereNotIn('id', $programasInscritosIds)
            ->get();

        return view('emprendedores.show', compact('emprendedor', 'programasDisponibles'));
    }

    // Busca el emprendedor en la base de datos y muestra el formulario con sus datos actuales.
    // Corresponde a la ruta GET /emprendedores/{id}/edit
    public function edit($id)
    {
        // findOrFail lanza un error 404 automaticamente si el ID no existe
        $emprendedor = Emprendedor::findOrFail($id);
        return view('emprendedores.edit', compact('emprendedor'));
    }

    // Valida los datos del formulario y actualiza el emprendedor en la base de datos.
    // Corresponde a la ruta PUT /emprendedores/{id}
    public function update(Request $request, $id)
    {
        // Aplica las mismas reglas de validacion que en el registro
        $request->validate([
            'nombre'              => 'required|string|max:255',
            'actividad_economica' => 'required|in:artesano,panadería,taller,tienda,otro',
            'ubicacion'           => 'required|string|max:255',
            'telefono'            => 'required|string|max:20',
            'email'               => 'required|email|max:255',
            'estado'              => 'required|in:activo,inactivo',
        ]);

        // Busca el emprendedor y actualiza sus datos en la base de datos
        $emprendedor = Emprendedor::findOrFail($id);
        $emprendedor->update($request->only([
            'nombre', 'actividad_economica', 'ubicacion', 'telefono', 'email', 'estado'
        ]));

        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor actualizado exitosamente.');
    }

    // Elimina el emprendedor de la base de datos.
    // Corresponde a la ruta DELETE /emprendedores/{id}
    public function destroy($id)
    {
        // Busca el emprendedor y lo elimina permanentemente de la base de datos
        $emprendedor = Emprendedor::findOrFail($id);
        $emprendedor->delete();

        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor eliminado exitosamente.');
    }
}
