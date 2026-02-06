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
        Schema::create('reclamaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('dni', 8);
            $table->string('telefono', 20);
            $table->string('email');
            $table->text('detalle_reclamo');
            $table->text('pedido');
            $table->enum('estado', ['pendiente', 'en_proceso', 'resuelto', 'rechazado'])->default('pendiente');
            $table->text('respuesta')->nullable();
            $table->timestamp('fecha_respuesta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reclamaciones');
    }
};
