<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migración que agrega el campo 'estado' a la tabla pivote 'emprendedor_programa'
// y crea un índice único compuesto para evitar que un emprendedor se inscriba
// dos veces en el mismo programa de formación.
return new class extends Migration
{
    // Agrega la columna y el índice único al ejecutar 'php artisan migrate'
    public function up(): void
    {
        Schema::table('emprendedor_programa', function (Blueprint $table) {
            // Estado de la inscripción: en curso por defecto al inscribirse
            $table->enum('estado', ['en_curso', 'completado', 'cancelado'])
                ->default('en_curso')
                ->after('fecha_inscripcion');

            // Índice único compuesto: evita inscripciones duplicadas del mismo emprendedor en el mismo programa
            $table->unique(['emprendedor_id', 'programa_formacion_id'], 'emprendedor_programa_unique');
        });
    }

    // Elimina la columna y el índice si se revierte la migración con 'php artisan migrate:rollback'
    public function down(): void
    {
        Schema::table('emprendedor_programa', function (Blueprint $table) {
            $table->dropUnique('emprendedor_programa_unique');
            $table->dropColumn('estado');
        });
    }
};
