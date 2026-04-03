<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProgramaFormacion extends Model
{
    protected $table = 'programas_formacion';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function emprendedores(): BelongsToMany
    {
        return $this->belongsToMany(Emprendedor::class, 'emprendedor_programa')
            ->withPivot('fecha_inscripcion')
            ->withTimestamps();
    }
}
