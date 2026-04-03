<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emprendedor_programa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emprendedor_id')->constrained('emprendedores')->onDelete('cascade');
            $table->foreignId('programa_formacion_id')->constrained('programas_formacion')->onDelete('cascade');
            $table->date('fecha_inscripcion');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emprendedor_programa');
    }
};
