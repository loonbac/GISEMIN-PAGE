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
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre del trabajador
            $table->string('dni'); // DNI o documento
            $table->string('curso'); // Tipo de capacitación
            $table->date('fecha_emision'); // Fecha de emisión
            $table->string('codigo')->unique(); // Código único del certificado
            $table->date('fecha_vencimiento')->nullable(); // Fecha de vencimiento (1 año después de emisión)
            $table->enum('estado', ['vigente', 'expirado', 'cancelado'])->default('vigente');
            $table->text('observaciones')->nullable(); // Observaciones adicionales
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
