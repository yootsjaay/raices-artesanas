<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->foreignId('paquete_id')
                  ->nullable()
                  ->after('presentacione_id')
                  ->constrained('paquetes')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['paquete_id']);
            $table->dropColumn('paquete_id');
        });
    }
};