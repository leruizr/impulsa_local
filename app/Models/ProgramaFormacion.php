<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Modelo que representa un programa de formación ofrecido por la Alcaldía.
// Los programas son cursos o talleres a los que pueden inscribirse los emprendedores.
class ProgramaFormacion extends Model
{
    // Nombre explícito de la tabla en la base de datos
    protected $table = 'programas_formacion';

    // Campos que se pueden asignar masivamente (al crear o actualizar desde formulario)
    protected $fillable = [
        'nombre',
        'descripcion',
        'cupo_maximo', // Cantidad máxima de emprendedores que pueden inscribirse
        'estado',      // Puede ser 'activo' o 'inactivo'
    ];

    // Relación muchos a muchos con Emprendedor.
    // Un programa puede tener varios emprendedores inscritos y
    // un emprendedor puede estar en varios programas.
    // La tabla intermedia 'emprendedor_programa' guarda la fecha de inscripción y el estado.
    public function emprendedores(): BelongsToMany
    {
        return $this->belongsToMany(Emprendedor::class, 'emprendedor_programa')
            ->withPivot('fecha_inscripcion', 'estado') // Incluye los campos extra de la tabla pivot
            ->withTimestamps();                        // Gestiona automáticamente created_at y updated_at en la pivot
    }
}
