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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 80);
            $table->text('descripcion')->nullable(); // Cambiado a text para descripciones detalladas de la artesanía
            $table->integer('stock')->default(0);
            $table->string('img_url', 255)->nullable();
            $table->string('medida', 255)->nullable(); // Ej: "Grande", "Talla M"
            $table->tinyInteger('estado')->default(1);
            
            // LOGÍSTICA (Crucial para Envia.com)
            // Usamos decimal para precisión en envíos internacionales o nacionales
            $table->decimal('peso', 8, 2)->default(0.5);  // Peso en Kilogramos (kg)
            $table->decimal('largo', 8, 2)->default(10.0); // Dimensiones en Centímetros (cm)
            $table->decimal('ancho', 8, 2)->default(10.0);
            $table->decimal('alto', 8, 2)->default(10.0);
            $table->boolean('es_fragil')->default(false);  // Para Barro o Alebrijes

            // FINANZAS
            $table->decimal('precio_artesano', 10, 2); // Lo que recibe el maestro artesano
            $table->decimal('precio_venta', 10, 2);    // Precio final al público
            
            // RELACIONES
            // El artesano (Persona)
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade'); 
            $table->foreignId('presentacione_id')->constrained('presentaciones')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};