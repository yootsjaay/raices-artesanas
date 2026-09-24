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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            
            // Relación con el usuario (Importante que esté arriba)
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            
            // Clasificación (Añadí 'Admin' por si quieres guardar datos del admin también)
            $table->enum('tipo_persona', ['administrador', 'artesano', 'cliente']);
            // Datos Personales
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable(); // Solo una vez y tipo text para mayor capacidad
            
            // Contexto Regional (Comunidad Mixe)
            $table->string('municipio', 100); 
            $table->string('comunidad', 100)->nullable(); // Útil para Raíces Artesanas
            
            // Estado de la cuenta (1: Activo, 0: Inactivo)
            $table->tinyInteger('estado')->default(1);
            
            // Datos específicos de Artesano
            $table->string('nombre_taller')->nullable();
            $table->text('biografia')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};