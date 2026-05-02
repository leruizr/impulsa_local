<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Modelo que representa a un emprendedor registrado en el sistema.
// Cada emprendedor tiene datos personales y de negocio, y puede estar
// inscrito en varios programas de formación.
class Emprendedor extends Model
{
    // Nombre explícito de la tabla en la base de datos
    protected $table = 'emprendedores';

    // Campos que se pueden asignar masivamente (al crear o actualizar desde formulario)
    protected $fillable = [
        'nombre',
        'actividad_economica', // Tipo de negocio: artesano, panadería, taller, tienda u otro
        'ubicacion',
        'telefono',
        'email',
        'estado', // Puede ser 'activo' o 'inactivo'
    ];

    // Relación muchos a muchos con ProgramaFormacion.
    // Un emprendedor puede estar inscrito en varios programas y
    // un programa puede tener varios emprendedores.
    // La tabla intermedia 'emprendedor_programa' guarda además la fecha de inscripción y el estado.
    public function programasFormacion(): BelongsToMany
    {
        return $this->belongsToMany(ProgramaFormacion::class, 'emprendedor_programa')
            ->withPivot('fecha_inscripcion', 'estado') // Incluye los campos extra de la tabla pivot
            ->withTimestamps();                        // Gestiona automáticamente created_at y updated_at en la pivot
    }
}
