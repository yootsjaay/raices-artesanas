<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paquetes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('peso', 8, 2)->comment('kg');
            $table->decimal('largo', 8, 2)->comment('cm');
            $table->decimal('ancho', 8, 2)->comment('cm');
            $table->decimal('alto', 8, 2)->comment('cm');
            $table->string('envia_package_id')->nullable()->comment('ID del paquete en Envia.com');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};