<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\User;

class WelcomeController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['persona', 'categorias.caracteristica'])
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        // Ajustado a la carpeta 'cliente'
        return view('client.welcome', compact('productos'));
    }

    public function show($id)
    {
        // Buscamos por ID explícito para asegurar compatibilidad con tu route:list
        $producto = Producto::with([
            'persona', 
            'categorias.caracteristica', 
            'presentacione.caracteristica'
        ])->findOrFail($id);
            
        // Apuntamos a la vista correcta
        return view('client.producto.show', compact('producto'));
    }

    public function artisanShow($id)
    {
        $artesano = User::findOrFail($id); 
        
        $productos = Producto::where('user_id', $id) 
            ->where('stock', '>', 0)
            ->paginate(12);

        // Esta debería ser una vista de listado, no la de detalle de UN producto
        return view('client.artesano.show', compact('artesano', 'productos'));
    }
}
