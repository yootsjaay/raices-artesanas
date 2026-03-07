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
    {Schema::create('ordenes', function (Blueprint $table) {
        $table->id();
        $table->string('numero_pedido')->unique(); // Ej: MIXE-1002
        $table->foreignId('user_id')->constrained(); // Cliente que compra
        
        // Costos desglosados
        $table->decimal('subtotal', 10, 2); 
        $table->decimal('costo_envio', 10, 2)->default(0); 
        $table->decimal('comision_sistema', 10, 2); // Tus honorarios
        $table->decimal('total', 10, 2);
        
        $table->enum('estado_pago', ['pendiente', 'pagado', 'fallido'])->default('pendiente');
        $table->enum('estado_envio', ['preparando', 'en_camino', 'entregado'])->default('preparando');
        
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
