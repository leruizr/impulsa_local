<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migración que crea la tabla 'programas_formacion' en la base de datos.
// Esta tabla almacena los cursos y talleres que la Alcaldía ofrece a los emprendedores.
return new class extends Migration
{
    // Define la estructura de la tabla al ejecutar 'php artisan migrate'
    public function up(): void
    {
        Schema::create('programas_formacion', function (Blueprint $table) {
            $table->id();              // Clave primaria autoincremental
            $table->string('nombre');  // Nombre del programa (ej: Marketing Digital)
            $table->text('descripcion'); // Descripción extensa del programa
            $table->timestamps();      // Campos created_at y updated_at automáticos
        });
    }

    // Elimina la tabla si se revierte la migración con 'php artisan migrate:rollback'
    public function down(): void
    {
        Schema::dropIfExists('programas_formacion');
    }
};
