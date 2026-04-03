<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramaFormacionController extends Controller
{
    private function getProgramas()
    {
        return collect([
            (object) [
                'id' => 1,
                'nombre' => 'Marketing Digital',
                'descripcion' => 'Aprende a promocionar tu negocio en redes sociales y plataformas digitales para llegar a más clientes.',
            ],
            (object) [
                'id' => 2,
                'nombre' => 'Comercio Digital',
                'descripcion' => 'Herramientas y estrategias para vender tus productos y servicios por internet de forma efectiva.',
            ],
            (object) [
                'id' => 3,
                'nombre' => 'Contabilidad Básica',
                'descripcion' => 'Fundamentos de contabilidad para llevar las cuentas de tu negocio de manera organizada y cumplir con las obligaciones tributarias.',
            ],
            (object) [
                'id' => 4,
                'nombre' => 'Gestión Empresarial',
                'descripcion' => 'Desarrollo de habilidades administrativas para planificar, organizar y dirigir tu emprendimiento con éxito.',
            ],
        ]);
    }

    public function index()
    {
        $programas = $this->getProgramas();
        return view('programas.index', compact('programas'));
    }

    public function create()
    {
        return view('programas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        return redirect()->route('programas.index')
            ->with('success', 'Programa de formación creado exitosamente.');
    }
}
