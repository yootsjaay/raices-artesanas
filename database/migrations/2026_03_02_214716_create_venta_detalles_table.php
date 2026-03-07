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
      Schema::create('venta_detalles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade');
        $table->foreignId('producto_id')->constrained('productos'); // Cambiar a 'productos' o 'productos' según tu tabla
        $table->integer('cantidad');
        $table->decimal('precio_unitario', 10, 2); // Precio de venta en ese momento
        $table->decimal('comision_aplicada', 10, 2); // Copia de la comisión del artesano en ese momento
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_detalles');
    }
};
