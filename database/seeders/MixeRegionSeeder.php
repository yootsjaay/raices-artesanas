<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Documento;
use App\Models\Persona; // Estaba como Personas, debe ser Persona (en singular)
use App\Models\Proveedor;
use App\Models\Caracteristica;
use App\Models\Categoria;
use App\Models\MetodoEnvio;
use App\Models\Marcas;
use App\Models\Presentaciones;


class MixeRegionSeeder extends Seeder
{
    public function run(): void
    {

    
        // --- MARCAS (Talles o Cooperativas) ---
$m1 = Caracteristica::create(['nombre' => 'Cooperativa Mujeres Tlahui', 'estado' => 1]);
Marcas::create(['caracteristicas_id' => $m1->id]);

$m2 = Caracteristica::create(['nombre' => 'Artesanos del Sol', 'estado' => 1]);
Marcas::create(['caracteristicas_id' => $m2->id]);

// --- PRESENTACIONES (Empaque o Tamaño) ---
$p1 = Caracteristica::create(['nombre' => 'Pieza Única', 'estado' => 1]);
Presentaciones::create(['caracteristicas_id' => $p1->id]);

$p2 = Caracteristica::create(['nombre' => 'Paquete Regalo (Caja de Madera)', 'estado' => 1]);
Presentaciones::create(['caracteristicas_id' => $p2->id]);
        // 1. Tipos de Documento
        $dni = Documento::create(['tipo_documento' => 'INE']);
        Documento::create(['tipo_documento' => 'CURP']);

        // 2. Categorías (Se crean en Caracteristica y luego en Categoria)
        $c1 = Caracteristica::create(['nombre' => 'Textiles (Blusas y Camisas)', 'estado' => 1]);
        Categoria::create(['caracteristicas_id' => $c1->id]);

        $c2 = Caracteristica::create(['nombre' => 'Barro Rojo', 'estado' => 1]);
        Categoria::create(['caracteristicas_id' => $c2->id]);

        $c3 = Caracteristica::create(['nombre' => 'Café Orgánico', 'estado' => 1]);
        Categoria::create(['caracteristicas_id' => $c3->id]);


        // 3. Crear un Artesano Maestro (Tlahuitoltepec)
        // Nota: Asegúrate de que el modelo se llame Persona y no Personas
        $persona1 = Persona::create([
            'numero_documento' => '12345678',
            'nombre' => 'María',
            'apellido' => 'Guzmán',
            'municipio' => 'Santa María Tlahuitoltepec',
            'documento_id' => $dni->id,
            'estado' => 1
        ]);

        Proveedor::create([
            'persona_id' => $persona1->id,
            'nombre_taller' => 'Textiles Xaam',
            'biografia_artesano' => 'Maestra artesana especialista en el bordado de Tlahuitoltepec.',
            'comision_fija_sistema' => 50.00 
        ]);

        // 4. Métodos de Envío
        MetodoEnvio::create([
            'nombre' => 'Taxi Comunitario (Sierra Norte)',
            'tipo' => 'local',
            'tarifa_base' => 70.00
        ]);

        MetodoEnvio::create([
            'nombre' => 'Paquetería Internacional (DHL/FedEx vía envia.com)',
            'tipo' => 'plataforma_api',
            'tarifa_base' => 250.00
        ]);
        
    }
}