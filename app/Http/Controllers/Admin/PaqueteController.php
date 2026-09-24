<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paquete;
use App\Services\EnviaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;  
use App\Models\Categoria;
use App\Models\Presentacione;
use App\Models\Producto;



class PaqueteController extends Controller
{
    public function __construct(private EnviaService $envia) {}

    public function index()
    {
        $paquetes = Paquete::latest()->get();
        return view('admin.paquetes.index', compact('paquetes'));
    }
    public function create()
{
    $categorias    = Categoria::with('caracteristica')->get();
    $presentaciones = Presentacione::with('caracteristica')->get();
    $paquetes      = Paquete::where('activo', true)->get();

    return view('admin.productos.create', compact('categorias', 'presentaciones', 'paquetes'));
}

    public function store(Request $request)
{
    $data = $request->validate([
        'nombre' => 'required|string|max:100',
        'peso'   => 'required|numeric|min:0.1',
        'largo'  => 'required|numeric|min:1',
        'ancho'  => 'required|numeric|min:1',
        'alto'   => 'required|numeric|min:1',
    ]);

    try {
        // 1. Intentar crear en Envia.com
        $enviaData = $this->envia->createPackage($data);
        Log::info('Envia createPackage response: ', (array) $enviaData);

        // 2. Validar que la API respondió con un ID
        $enviaId = $enviaData['package_id'] ?? null;

        if (!$enviaId) {
             throw new \Exception('La API de Envia no devolvió un ID de paquete.');
        }

        // 3. Crear en base de datos local
        $paquete = Paquete::create([
            ...$data,
            'envia_package_id' => $enviaId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Paquete creado correctamente.',
            'data'    => $paquete,
        ]);

    } catch (\Exception $e) {
        Log::error('Error al crear paquete: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al procesar el paquete: ' . $e->getMessage(),
        ], 500);
    }
}
    public function show(Paquete $paquete)
    {
        return response()->json([
            'success' => true,
            'data'    => $paquete,
        ]);
    }

    public function update(Request $request, Paquete $paquete)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'peso'   => 'required|numeric|min:0.1',
            'largo'  => 'required|numeric|min:1',
            'ancho'  => 'required|numeric|min:1',
            'alto'   => 'required|numeric|min:1',
        ]);

        $paquete->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Paquete actualizado.',
        ]);
    }

    public function destroy(Paquete $paquete)
    {
        $paquete->update(['activo' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Paquete desactivado.',
        ]);
    }
}