<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emprendedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('actividad_economica', ['artesano', 'panadería', 'taller', 'tienda', 'otro']);
            $table->string('ubicacion');
            $table->string('telefono');
            $table->string('email');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emprendedores');
    }
};
