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

        // Un emprendedor solo puede editar su propio perfil; el admin puede editar cualquiera.
        $this->autorizarAccesoAlEmprendedor($emprendedor);

        return view('emprendedores.edit', compact('emprendedor'));
    }

    // Valida los datos del formulario y actualiza el emprendedor en la base de datos.
    // Corresponde a la ruta PUT /emprendedores/{id}
    public function update(Request $request, $id)
    {
        // Busca el emprendedor y verifica el permiso antes de validar
        $emprendedor = Emprendedor::findOrFail($id);
        $this->autorizarAccesoAlEmprendedor($emprendedor);

        // Reglas base; el estado solo lo puede modificar el admin
        $reglas = [
            'nombre'              => 'required|string|max:255',
            'actividad_economica' => 'required|in:artesano,panadería,taller,tienda,otro',
            'ubicacion'           => 'required|string|max:255',
            'telefono'            => 'required|string|max:20',
            'email'               => 'required|email|max:255',
        ];
        if (auth()->check() && auth()->user()->esAdmin()) {
            $reglas['estado'] = 'required|in:activo,inactivo';
        }

        $datos = $request->validate($reglas);

        $emprendedor->update($datos);

        // Si el emprendedor edita su propio perfil, vuelve a su detalle.
        // Si es el admin, vuelve al listado completo.
        if (auth()->check() && auth()->user()->esEmprendedor()) {
            return redirect()->route('emprendedores.show', $emprendedor->id)
                ->with('success', 'Tus datos fueron actualizados exitosamente.');
        }

        return redirect()->route('emprendedores.index')
            ->with('success', 'Emprendedor actualizado exitosamente.');
    }

    // Verifica que el usuario autenticado pueda operar sobre este emprendedor.
    // Admin: siempre. Emprendedor: solo si es su propio registro.
    protected function autorizarAccesoAlEmprendedor(Emprendedor $emprendedor): void
    {
        $usuario = auth()->user();
        if (! $usuario) {
            abort(403);
        }
        if ($usuario->esAdmin()) {
            return;
        }
        if ($usuario->esEmprendedor() && $usuario->emprendedor_id === $emprendedor->id) {
            return;
        }
        abort(403, 'No tiene permiso para acceder a este emprendedor.');
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
