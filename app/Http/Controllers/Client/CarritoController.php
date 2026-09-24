<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use App\Models\CarritoItem;

class CarritoController extends Controller
{
    /**
     * Añade un producto al carrito.
     */
   public function add(Request $request)
{
    try {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1'
        ]);

        $userId = auth()->id();
        $sessionId = session()->getId();
        $productoId = $request->producto_id;
        $cantidad = $request->cantidad;

        // 1. BUSCAR O CREAR EL ITEM QUE SE ESTÁ AGREGANDO
        $item = CarritoItem::where('producto_id', $productoId)
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) $query->where('user_id', $userId);
                else $query->where('session_id', $sessionId);
            })->first();

        if ($item) {
            $item->increment('cantidad', $cantidad);
        } else {
            $item = CarritoItem::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'producto_id' => $productoId,
                'cantidad' => $cantidad
            ]);
        }

       

        // 3. RETORNAR EL CONTEO TOTAL REAL
        $totalCount = CarritoItem::where(function($query) use ($userId, $sessionId) {
            if ($userId) $query->where('user_id', $userId);
            else $query->where('session_id', $sessionId);
        })->sum('cantidad');

        return response()->json([
            'success' => true,
            'count' => $totalCount,
            'message' => 'Producto añadido'
        ]);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    /**
     * Cargar carrito
     */
   public function load()
{
    try {
        $userId = auth()->id();
        $sessionId = session()->getId();

        // Buscamos en la base de datos, no en la sesión
        $items = CarritoItem::with('producto')
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) $query->where('user_id', $userId);
                else $query->where('session_id', $sessionId);
            })->get()
            ->map(function ($item) {
                return [
                    'id' => $item->producto_id, // Usamos 'id' para el botón de eliminar del JS
                    'nombre' => $item->producto->nombre,
                    'precio' => (float)$item->producto->precio_venta,
                    'cantidad' => $item->cantidad,
                    'imagen' => $item->producto->img_url
                ];
            });

        return response()->json(['items' => $items]);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    /**
     * Actualizar cantidad
     */
  public function update(Request $request)
{
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'action' => 'required|in:increment,decrement'
    ]);

    $userId = auth()->id();
    $sessionId = session()->getId();
    
    $item = CarritoItem::where('producto_id', $request->producto_id)
        ->where(function($query) use ($userId, $sessionId) {
            if ($userId) $query->where('user_id', $userId);
            else $query->where('session_id', $sessionId);
        })->first();

    if ($item) {
        if ($request->action === 'increment') {
            $item->increment('cantidad');
        } elseif ($request->action === 'decrement' && $item->cantidad > 1) {
            $item->decrement('cantidad');
        }
    }

    return response()->json(['success' => true]);
}

public function remove(Request $request)
{
    $request->validate(['producto_id' => 'required']);

    $userId = auth()->id();
    $sessionId = session()->getId();

    CarritoItem::where('producto_id', $request->producto_id)
        ->where(function($query) use ($userId, $sessionId) {
            if ($userId) $query->where('user_id', $userId);
            else $query->where('session_id', $sessionId);
        })->delete();

    return response()->json(['success' => true]);
}
}