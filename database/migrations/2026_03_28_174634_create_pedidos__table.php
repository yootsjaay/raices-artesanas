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
       Schema::create('pedidos', function (Blueprint $table) {
    $table->id();
    $table->string('numero_pedido')->unique(); // Ej: RA-2024-001
    $table->string('nombre_cliente');
    $table->string('telefono');
    $table->string('municipio');
    $table->text('direccion');
    $table->string('paqueteria');
    $table->decimal('costo_envio', 10, 2);
    $table->decimal('total', 10, 2);
    $table->enum('status_pago', ['pendiente', 'pagado', 'cancelado'])->default('pendiente');
    $table->enum('status_envio', ['preparando', 'enviado', 'entregado'])->default('preparando');
    $table->text('notas_pago')->nullable(); // Para guardar referencia de OXXO o transferencia
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos_');
    }
};
