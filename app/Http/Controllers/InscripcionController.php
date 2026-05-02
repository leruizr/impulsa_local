<?php

namespace App\Http\Controllers;

use App\Models\Emprendedor;
use App\Models\ProgramaFormacion;
use Illuminate\Http\Request;

// Controlador que gestiona la inscripcion de emprendedores en programas de formacion.
// Trabaja sobre la tabla pivote 'emprendedor_programa' a traves de la relacion
// muchos a muchos definida en los modelos Emprendedor y ProgramaFormacion.
class InscripcionController extends Controller
{
    // Inscribe un emprendedor en un programa de formacion.
    // Corresponde a la ruta POST /emprendedores/{emprendedor}/inscripciones
    public function store(Request $request, Emprendedor $emprendedor)
    {
        // Valida que el programa exista y que el emprendedor no este ya inscrito en el
        $request->validate([
            'programa_formacion_id' => [
                'required',
                'integer',
                'exists:programas_formacion,id',
                // Regla que evita inscribir dos veces al mismo emprendedor en el mismo programa
                function ($attribute, $value, $fail) use ($emprendedor) {
                    if ($emprendedor->programasFormacion()->where('programa_formacion_id', $value)->exists()) {
                        $fail('El emprendedor ya está inscrito en este programa.');
                    }
                },
            ],
        ]);

        // Crea la inscripcion en la tabla pivote con la fecha actual y estado 'en_curso'
        $emprendedor->programasFormacion()->attach($request->programa_formacion_id, [
            'fecha_inscripcion' => now()->toDateString(),
            'estado'            => 'en_curso',
        ]);

        return redirect()->route('emprendedores.show', $emprendedor->id)
            ->with('success', 'Emprendedor inscrito exitosamente en el programa.');
    }

    // Cancela la inscripcion de un emprendedor en un programa.
    // Corresponde a la ruta DELETE /emprendedores/{emprendedor}/inscripciones/{programa}
    public function destroy(Emprendedor $emprendedor, ProgramaFormacion $programa)
    {
        // detach elimina el registro correspondiente en la tabla pivote
        $emprendedor->programasFormacion()->detach($programa->id);

        return redirect()->route('emprendedores.show', $emprendedor->id)
            ->with('success', 'Inscripción cancelada exitosamente.');
    }
}
