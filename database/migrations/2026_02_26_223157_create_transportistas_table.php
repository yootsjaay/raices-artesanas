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
        Schema::create('transportistas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
        $table->string('tipo_unidad'); // Taxi, Urbano, etc.
        $table->string('numero_unidad', 50)->nullable(); // Número económico
        $table->string('ruta_principal'); // Ej: Tlahuitoltepec - Oaxaca
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportistas');
    }
};
