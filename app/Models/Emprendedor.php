<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Emprendedor extends Model
{
    protected $table = 'emprendedores';

    protected $fillable = [
        'nombre',
        'actividad_economica',
        'ubicacion',
        'telefono',
        'email',
        'estado',
    ];

    public function programasFormacion(): BelongsToMany
    {
        return $this->belongsToMany(ProgramaFormacion::class, 'emprendedor_programa')
            ->withPivot('fecha_inscripcion')
            ->withTimestamps();
    }
}
