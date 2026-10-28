<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleo_id')->constrained('empleos')->restrictOnDelete();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('solicitante');
            $table->string('prioridad', 10)->default('media');     // baja | media | alta
            $table->string('estado', 20)->default('pendiente');    // pendiente | en_proceso | terminada
            $table->date('fecha_solicitud');
            $table->date('fecha_cierre')->nullable();
            $table->foreignId('creado_por')->constrained('usuarios')->restrictOnDelete();
            $table->foreignId('asignado_a')->nullable()->constrained('usuarios')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
