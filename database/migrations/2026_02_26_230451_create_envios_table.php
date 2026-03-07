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

    Schema::create('envios', function (Blueprint $table) {
        $table->id();
        $table->foreignId('orden_id')->constrained('ordenes')->onDelete('cascade');
        
        // Logística Mixta
        $table->string('metodo'); // 'Taxi Local', 'DHL', 'FedEx'
        $table->string('tracking_number')->nullable(); // Aquí pegas el ID de envia.com
        $table->string('url_etiqueta')->nullable(); // PDF de la guía
        
        $table->text('detalles_entrega')->nullable(); // "Terminal de Tlahui"
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
