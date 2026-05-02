<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migración que agrega los campos 'cupo_maximo' y 'estado' a la tabla 'programas_formacion'.
// Estos campos permiten controlar cuántos emprendedores pueden inscribirse en cada programa
// y si el programa está disponible o no para nuevas inscripciones.
return new class extends Migration
{
    // Agrega las columnas nuevas al ejecutar 'php artisan migrate'
    public function up(): void
    {
        Schema::table('programas_formacion', function (Blueprint $table) {
            $table->integer('cupo_maximo')->default(0)->after('descripcion');         // Cantidad máxima de emprendedores que pueden inscribirse
            $table->enum('estado', ['activo', 'inactivo'])->default('activo')->after('cupo_maximo'); // Disponibilidad del programa
        });
    }

    // Elimina las columnas si se revierte la migración con 'php artisan migrate:rollback'
    public function down(): void
    {
        Schema::table('programas_formacion', function (Blueprint $table) {
            $table->dropColumn(['cupo_maximo', 'estado']);
        });
    }
};
