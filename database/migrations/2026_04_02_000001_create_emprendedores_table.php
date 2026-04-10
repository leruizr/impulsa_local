<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migración que crea la tabla 'emprendedores' en la base de datos.
// Esta tabla almacena la información de cada emprendedor registrado en el sistema.
return new class extends Migration
{
    // Define la estructura de la tabla al ejecutar 'php artisan migrate'
    public function up(): void
    {
        Schema::create('emprendedores', function (Blueprint $table) {
            $table->id();                                                                        // Clave primaria autoincremental
            $table->string('nombre');                                                            // Nombre completo del emprendedor
            $table->enum('actividad_economica', ['artesano', 'panadería', 'taller', 'tienda', 'otro']); // Tipo de negocio (valores fijos)
            $table->string('ubicacion');                                                         // Dirección o barrio del negocio
            $table->string('telefono');                                                          // Número de contacto
            $table->string('email');                                                             // Correo electrónico
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');                  // Estado del emprendedor (activo por defecto)
            $table->timestamps();                                                                // Campos created_at y updated_at automáticos
        });
    }

    // Elimina la tabla si se revierte la migración con 'php artisan migrate:rollback'
    public function down(): void
    {
        Schema::dropIfExists('emprendedores');
    }
};
