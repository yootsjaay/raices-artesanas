<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Documento;
use App\Models\Caracteristica;
use App\Models\Categoria;
use App\Models\MetodoEnvio;
use App\Models\Marcas;
use App\Models\Presentaciones;

class MixeRegionSeeder extends Seeder
{
    public function run(): void
    {
        // --- MARCAS (Cooperativas o Identidad de GV-LINK) ---
        // Se mantiene para clasificar el origen de los productos
        $m1 = Caracteristica::create(['nombre' => 'Cooperativa Mujeres Tlahui', 'estado' => 1]);
        Marcas::create(['caracteristicas_id' => $m1->id]);

        $m2 = Caracteristica::create(['nombre' => 'Artesanos del Sol', 'estado' => 1]);
        Marcas::create(['caracteristicas_id' => $m2->id]);

        // --- PRESENTACIONES (Empaque o Tamaño) ---
        $p1 = Caracteristica::create(['nombre' => 'Pieza Única', 'estado' => 1]);
        Presentaciones::create(['caracteristicas_id' => $p1->id]);

        $p2 = Caracteristica::create(['nombre' => 'Paquete Regalo (Caja de Madera)', 'estado' => 1]);
        Presentaciones::create(['caracteristicas_id' => $p2->id]);

        // --- 1. TIPOS DE DOCUMENTO ---
        Documento::create(['tipo_documento' => 'INE']);
        Documento::create(['tipo_documento' => 'CURP']);

        // --- 2. CATEGORÍAS (Estructura Caracteristica -> Categoria) ---
        $c1 = Caracteristica::create(['nombre' => 'Textiles (Blusas y Camisas)', 'estado' => 1]);
        Categoria::create(['caracteristicas_id' => $c1->id]);

        $c2 = Caracteristica::create(['nombre' => 'Barro Rojo', 'estado' => 1]);
        Categoria::create(['caracteristicas_id' => $c2->id]);

        $c3 = Caracteristica::create(['nombre' => 'Café Orgánico', 'estado' => 1]);
        Categoria::create(['caracteristicas_id' => $c3->id]);

        // --- 3. MÉTODOS DE ENVÍO (Logística Local y Externa) ---
        MetodoEnvio::create([
            'nombre' => 'Taxi Comunitario (Sierra Norte)',
            'tipo' => 'local',
            'tarifa_base' => 70.00
        ]);

        MetodoEnvio::create([
            'nombre' => 'Paquetería Nacional (DHL/FedEx)',
            'tipo' => 'plataforma_api',
            'tarifa_base' => 250.00
        ]);
    }
}