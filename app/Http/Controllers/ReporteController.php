<?php

namespace App\Http\Controllers;

use App\Models\Emprendedor;
use App\Models\ProgramaFormacion;

// Controlador que genera los reportes administrativos del sistema.
// Solo accesible para usuarios con rol 'admin' (restricción aplicada en las rutas).
class ReporteController extends Controller
{
    // Página principal de reportes con los enlaces a cada reporte disponible.
    // Corresponde a la ruta GET /reportes
    public function index()
    {
        return view('reportes.index');
    }

    // Reporte de emprendedores activos en el sistema (req #8).
    // Lista todos los emprendedores con estado = 'activo' y el total.
    // Corresponde a la ruta GET /reportes/emprendedores-activos
    public function emprendedoresActivos()
    {
        // Carga los emprendedores activos con la cantidad de programas en los que están inscritos
        $emprendedores = Emprendedor::with('programasFormacion')
            ->where('estado', 'activo')
            ->orderBy('nombre')
            ->get();

        $total = $emprendedores->count();

        return view('reportes.emprendedores_activos', compact('emprendedores', 'total'));
    }

    // Reporte de emprendedores inscritos en cada programa de formación (req #9).
    // Para cada programa muestra la cantidad de inscritos y el listado completo.
    // Corresponde a la ruta GET /reportes/inscripciones
    public function inscripcionesPorPrograma()
    {
        // Carga los programas con sus emprendedores inscritos
        $programas = ProgramaFormacion::with('emprendedores')
            ->orderBy('nombre')
            ->get();

        // Total de inscripciones agregadas (suma de inscritos en todos los programas)
        $totalInscripciones = $programas->sum(fn($p) => $p->emprendedores->count());

        return view('reportes.inscripciones_programa', compact('programas', 'totalInscripciones'));
    }
}
