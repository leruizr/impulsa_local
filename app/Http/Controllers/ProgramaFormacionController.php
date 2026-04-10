<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Controlador que gestiona los programas de formación ofrecidos a los emprendedores.
// Por ahora trabaja con datos en memoria (sin base de datos) para propósitos de desarrollo.
class ProgramaFormacionController extends Controller
{
    // Retorna una colección de programas de ejemplo (datos estáticos en memoria).
    // Esta función simula lo que luego será una consulta real a la base de datos.
    private function getProgramas()
    {
        return collect([
            (object) [
                'id'          => 1,
                'nombre'      => 'Marketing Digital',
                'descripcion' => 'Aprende a promocionar tu negocio en redes sociales y plataformas digitales para llegar a más clientes.',
            ],
            (object) [
                'id'          => 2,
                'nombre'      => 'Comercio Digital',
                'descripcion' => 'Herramientas y estrategias para vender tus productos y servicios por internet de forma efectiva.',
            ],
            (object) [
                'id'          => 3,
                'nombre'      => 'Contabilidad Básica',
                'descripcion' => 'Fundamentos de contabilidad para llevar las cuentas de tu negocio de manera organizada y cumplir con las obligaciones tributarias.',
            ],
            (object) [
                'id'          => 4,
                'nombre'      => 'Gestión Empresarial',
                'descripcion' => 'Desarrollo de habilidades administrativas para planificar, organizar y dirigir tu emprendimiento con éxito.',
            ],
        ]);
    }

    // Muestra la lista de todos los programas de formación disponibles.
    // Corresponde a la ruta GET /programas
    public function index()
    {
        $programas = $this->getProgramas();
        return view('programas.index', compact('programas'));
    }

    // Muestra el formulario para crear un nuevo programa de formación.
    // Corresponde a la ruta GET /programas/create
    public function create()
    {
        return view('programas.create');
    }

    // Recibe y valida los datos del formulario de creación, luego redirige al listado.
    // Corresponde a la ruta POST /programas
    public function store(Request $request)
    {
        // Valida que el nombre y la descripción estén presentes y sean texto válido
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        // Redirige al listado con mensaje de éxito (aún no persiste en BD)
        return redirect()->route('programas.index')
            ->with('success', 'Programa de formación creado exitosamente.');
    }
}
