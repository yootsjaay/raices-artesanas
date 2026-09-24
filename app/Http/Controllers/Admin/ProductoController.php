<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Presentacione;
use App\Models\Categoria;
use App\Models\Persona;
use App\Models\Paquete;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Producto::with(['presentacione.caracteristica', 'categorias.caracteristica', 'persona']);

        if ($user->hasRole('administrador')) {
            $productos = $query->get();
        } else {
            $persona = $user->persona;
            $productos = $persona ? $query->where('persona_id', $persona->id)->get() : collect();
        }

        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::with('caracteristica')->get();
        $presentaciones = Presentacione::with('caracteristica')->get();
        // Cargamos los paquetes predefinidos para que el artesano elija uno si aplica
        $paquetes = Paquete::where('activo', true)->get();

        return view('admin.productos.create', compact('categorias', 'presentaciones', 'paquetes'));
    }

    public function store(Request $request)
    {
        // 1. Validación extendida con campos de logística
        $request->validate([
            'nombre' => 'required|string|max:80',
            'precio_artesano' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'presentacione_id' => 'required|exists:presentaciones,id',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // Nuevos campos requeridos para Envia.com
            'peso' => 'required|numeric|min:0.1',
            'largo' => 'required|numeric|min:1',
            'ancho' => 'required|numeric|min:1',
            'alto' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();
        $persona = $user->persona; 

        if (!$persona) {
            return back()->withErrors(['error' => 'Perfil de artesano no encontrado.'])->withInput();
        }

        $path_img = null;
        if ($request->hasFile('imagen')) {
            $path_img = $request->file('imagen')->store('productos', 'public');
        }

        // Lógica de precio: comisión fija
        $comision_sistema = 50.00; 
        $precio_final = $request->precio_artesano + $comision_sistema;

        try {
            $producto = Producto::create([
                'codigo' => 'ART-' . strtoupper(Str::random(6)),
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio_artesano' => $request->precio_artesano,
                'precio_venta' => $precio_final,
                'stock' => $request->stock,
                'estado' => 1,
                'presentacione_id' => $request->presentacione_id,
                'persona_id' => $persona->id, 
                'medida' => $request->medida,
                'img_url' => $path_img,
                // Datos de Logística
                'peso' => $request->peso,
                'largo' => $request->largo,
                'ancho' => $request->ancho,
                'alto' => $request->alto,
                'es_fragil' => $request->has('es_fragil'),
            ]);

            $producto->categorias()->attach($request->categoria_id);

            return redirect()->route('administrador.productos.index')
                ->with('success', "Artesanía '{$producto->nombre}' registrada correctamente.");

        } catch (\Exception $e) {
            if ($path_img) Storage::disk('public')->delete($path_img);
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Producto $producto)
    {
        $user = auth()->user();

        if ($user->hasRole('artesano') && $producto->persona_id !== $user->persona->id) {
            abort(403);
        }

        $categorias = Categoria::with('caracteristica')->get();
        $presentaciones = Presentacione::with('caracteristica')->get();
        $paquetes = Paquete::where('activo', true)->get();
        
        $artesanos = $user->hasRole('administrador') 
            ? Persona::where('tipo_persona', 'artesano')->get() 
            : [];

        return view('admin.productos.edit', compact('producto', 'categorias', 'presentaciones', 'paquetes', 'artesanos'));
    }

    public function update(Request $request, Producto $producto)
    {
        $user = auth()->user();

        $request->validate([
            'nombre' => 'required|string|max:80',
            'precio_artesano' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'presentacione_id' => 'required|exists:presentaciones,id',
            'stock' => 'required|integer|min:0',
            'peso' => 'required|numeric|min:0.1',
            'largo' => 'required|numeric|min:1',
            'ancho' => 'required|numeric|min:1',
            'alto' => 'required|numeric|min:1',
        ]);

        if ($user->hasRole('artesano') && $producto->persona_id !== $user->persona->id) {
            return back()->withErrors(['error' => 'No autorizado.']);
        }

        $path_img = $producto->img_url;
        if ($request->hasFile('imagen')) {
            if ($producto->img_url) Storage::disk('public')->delete($producto->img_url);
            $path_img = $request->file('imagen')->store('productos', 'public');
        }

        try {
            $producto->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio_artesano' => $request->precio_artesano,
                'precio_venta' => $request->precio_artesano + 50.00,
                'stock' => $request->stock,
                'presentacione_id' => $request->presentacione_id,
                'medida' => $request->medida,
                'img_url' => $path_img,
                'peso' => $request->peso,
                'largo' => $request->largo,
                'ancho' => $request->ancho,
                'alto' => $request->alto,
                'es_fragil' => $request->has('es_fragil'),
                'persona_id' => $user->hasRole('administrador') ? $request->persona_id : $producto->persona_id,
            ]);

            $producto->categorias()->sync($request->categoria_id);

            return redirect()->route('administrador.productos.index')
                ->with('success', 'Artesanía actualizada.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $user = auth()->user();

            if (!$user->hasRole('administrador') && $producto->persona_id !== $user->persona->id) {
                return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
            }

            if ($producto->img_url) Storage::disk('public')->delete($producto->img_url);
            $producto->categorias()->detach();
            $producto->delete();

            return response()->json(['success' => true, 'message' => 'Producto eliminado']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}