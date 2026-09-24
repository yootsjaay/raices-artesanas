<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('envia_shipment_id')->nullable()->after('status_envio');
            $table->string('servicio_envio')->nullable()->after('envia_shipment_id');
            $table->string('guia_url')->nullable()->after('servicio_envio');
            $table->string('numero_guia')->nullable()->after('guia_url');
            $table->string('codigo_postal_destino', 10)->nullable()->after('numero_guia');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn([
                'envia_shipment_id',
                'servicio_envio',
                'guia_url',
                'numero_guia',
                'codigo_postal_destino',
            ]);
        });
    }
};