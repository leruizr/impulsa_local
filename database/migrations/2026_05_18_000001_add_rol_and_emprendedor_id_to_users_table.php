<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migración aditiva que agrega el rol del usuario (admin o emprendedor)
// y la relación opcional con el emprendedor asociado a la cuenta.
// No modifica las columnas existentes de la tabla users.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rol del usuario: distingue entre administrador y emprendedor.
            // Por defecto se asigna 'emprendedor' para no romper datos previos.
            $table->enum('rol', ['admin', 'emprendedor'])
                ->default('emprendedor')
                ->after('password');

            // FK opcional al emprendedor asociado (solo para usuarios con rol 'emprendedor').
            // Si se elimina el emprendedor, la cuenta queda con emprendedor_id en NULL.
            $table->foreignId('emprendedor_id')
                ->nullable()
                ->after('rol')
                ->constrained('emprendedores')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['emprendedor_id']);
            $table->dropColumn(['emprendedor_id', 'rol']);
        });
    }
};
