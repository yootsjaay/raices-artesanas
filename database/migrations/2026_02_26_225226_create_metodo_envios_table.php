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

    Schema::create('metodo_envios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); // Ej: "Taxi Comunitario"
        $table->enum('tipo', ['local', 'plataforma_api']); 
        $table->decimal('tarifa_base', 10, 2)->default(0.00); // <--- ESTA ES LA QUE FALTA
        $table->string('punto_recepcion')->nullable(); 
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metodo_envios');
    }
};
