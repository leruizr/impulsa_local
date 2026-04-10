<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migración que crea la tabla pivot 'emprendedor_programa'.
// Esta tabla intermedia gestiona la relación muchos a muchos entre
// emprendedores y programas de formación. Además guarda la fecha en
// que el emprendedor se inscribió al programa.
return new class extends Migration
{
    // Define la estructura de la tabla al ejecutar 'php artisan migrate'
    public function up(): void
    {
        Schema::create('emprendedor_programa', function (Blueprint $table) {
            $table->id();

            // Llave foránea hacia la tabla 'emprendedores'.
            // Si se elimina un emprendedor, sus inscripciones se eliminan en cascada.
            $table->foreignId('emprendedor_id')->constrained('emprendedores')->onDelete('cascade');

            // Llave foránea hacia la tabla 'programas_formacion'.
            // Si se elimina un programa, las inscripciones asociadas se eliminan en cascada.
            $table->foreignId('programa_formacion_id')->constrained('programas_formacion')->onDelete('cascade');

            $table->date('fecha_inscripcion'); // Fecha en que el emprendedor se inscribió al programa
            $table->timestamps();              // Campos created_at y updated_at automáticos
        });
    }

    // Elimina la tabla si se revierte la migración con 'php artisan migrate:rollback'
    public function down(): void
    {
        Schema::dropIfExists('emprendedor_programa');
    }
};
