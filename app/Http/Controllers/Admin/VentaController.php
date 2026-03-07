<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Productos;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
  public function create() {
    $productos = Productos::where('estado', 1)->where('stock', '>', 0)->get();
    return view('ventas.create', compact('productos'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación: Esperamos un array de productos
        $request->validate([
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'monto_transporte' => 'required|numeric|min:0',
        ]);

        try {
            // Iniciamos una transacción 
            return DB::transaction(function () use ($request) {
                
                $totalVenta = 0;
                $totalArtesano = 0;
                $totalPlataforma = 0;
                $detallesParaInsertar = [];

                foreach ($request->productos as $item) {
                    $producto = Productos::with('artesano')->findOrFail($item['id']);

                    // A. Verificar Stock
                    if ($producto->stock < $item['cantidad']) {
                        throw new \Exception("Stock insuficiente para: {$producto->nombre}");
                    }

                    // B. Cálculos económicos por producto
                    $subtotal = $producto->precio_venta * $item['cantidad'];
                    $costoArtesanoTotal = $producto->precio_artesano * $item['cantidad'];
                    $comisionProducto = ($producto->precio_venta - $producto->precio_artesano) * $item['cantidad'];

                    // Acumuladores para la cabecera
                    $totalVenta += $subtotal;
                    $totalArtesano += $costoArtesanoTotal;
                    $totalPlataforma += $comisionProducto;

                    // C. Descontar Stock
                    $producto->decrement('stock', $item['cantidad']);

                    // D. Preparar el detalle para después
                    $detallesParaInsertar[] = [
                        'producto_id' => $producto->id,
                        'cantidad' => $item['cantidad'],
                        'precio_unitario' => $producto->precio_venta,
                        'comision_aplicada' => $producto->artesano->comision_fija_sistema,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // 2. Crear la Cabecera de la Venta
                $venta = Venta::create([
                    'user_id' => Auth::id(),
                    'total' => $totalVenta + $request->monto_transporte,
                    'monto_artesano' => $totalArtesano,
                    'comision_plataforma' => $totalPlataforma,
                    'monto_transporte' => $request->monto_transporte,
                ]);

                // 3. Guardar los detalles vinculados a la venta
                foreach ($detallesParaInsertar as $detalle) {
                    $detalle['venta_id'] = $venta->id;
                    VentaDetalle::create($detalle);
                }

                return redirect()->route('ventas.index')
                    ->with('success', "Venta #{$venta->id} realizada con éxito. Stock actualizado.");
            });

        } catch (\Exception $e) {
            return back()->with('error', "Error en la venta: " . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
