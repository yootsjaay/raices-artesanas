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
        Schema::create('caracteristicas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 60);
            $table->string('descripcion', 255)->nullable();
            $table->boolean('estado')->default(1);   // Corregido: default
            $table->boolean('destacado')->default(0); // Corregido: default
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Evita errores al hacer rollback si existen FKs externas (ej. tabla marcas)
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('caracteristicas');
        Schema::enableForeignKeyConstraints();
    }
};
