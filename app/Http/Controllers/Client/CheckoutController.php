<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Muestra la pantalla de pago.
     * Protegemos con el middleware auth para asegurar que el usuario esté logueado.
     */
   public function index()
{
    if (!Auth::check()) {
        return redirect()->route('login')
            ->with('info', 'Por favor, inicia sesión para finalizar tu compra.');
    }

    // ✅ Leer de BD, no de session()
    $carrito = \App\Models\CarritoItem::where('user_id', Auth::id())
                ->with('producto')
                ->get();

    if ($carrito->isEmpty()) {
        return redirect()->route('tienda.index')
            ->with('info', 'Tu carrito está vacío');
    }

    $total = $carrito->sum(fn($item) => $item->precio * $item->cantidad);

    return view('client.checkout.index', compact('carrito', 'total'));
}

    /**
     * Procesa la orden de compra.
     */
    public function store(Request $request)
{
    $carrito = \App\Models\CarritoItem::where('user_id', Auth::id())
                ->with('producto')
                ->get();

    if ($carrito->isEmpty()) {
        return redirect()->route('tienda.index');
    }

    $request->validate([
        'direccion' => 'required|string|max:255',
        'telefono'  => 'required|string|max:20',
    ]);

    try {
        DB::beginTransaction();

        $pedido = Pedido::create([
            'user_id'            => Auth::id(),
            'codigo_seguimiento' => 'RA-' . strtoupper(Str::random(8)),
            'total'              => $carrito->sum(fn($i) => $i->precio * $i->cantidad),
            'estado'             => 'pendiente',
            'direccion_envio'    => $request->direccion,
            'telefono_contacto'  => $request->telefono,
        ]);

        foreach ($carrito as $item) {
            PedidoProducto::create([
                'pedido_id'       => $pedido->id,
                'producto_id'     => $item->producto_id,
                'cantidad'        => $item->cantidad,
                'precio_unitario' => $item->precio,
            ]);
        }

        // ✅ Limpiar carrito de BD
        \App\Models\CarritoItem::where('user_id', Auth::id())->delete();

        DB::commit();

        return redirect()->route('tienda.index')
            ->with('success', '¡Gracias! Tu pedido ' . $pedido->codigo_seguimiento . ' fue recibido.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Hubo un problema al procesar tu pedido. Inténtalo de nuevo.');
    }
}
}