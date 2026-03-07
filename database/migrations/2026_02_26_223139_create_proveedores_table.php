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
       Schema::create('proveedores', function (Blueprint $table) {
        $table->id();
        $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
        $table->string('nombre_taller')->nullable();
        $table->text('biografia_artesano')->nullable(); // Para el valor agregado en la web
        $table->decimal('comision_fija_sistema', 8, 2)->default(0.00); // Tus honorarios por mantenimiento
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
