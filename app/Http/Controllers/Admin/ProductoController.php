<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marcas; // Asegúrate que el modelo sea Marcas o Marca (singular/plural)
use App\Models\Presentaciones;
use Illuminate\Support\Str; // Importante para generar el código
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
 public function index()
{
    $user = auth()->user();

    $query = Producto::with(['user.persona', 'categoria.caracteristica']);
    //  Aplicamos el filtro según el Rol
    if ($user->hasRole('Admin')) {
        // El administrador ve acceso total
        $productos = $query->get();
    } else {
        // El artesano solo ve sus propios productos
        $productos = $query->where('user_id', $user->id)->get();
    }

    // 3. Retornamos a la vista
    return view('productos.index', compact('productos'));
}

    public function create()
{
    $user = auth()->user();
    
    // Si es Admin, cargamos todos para que pueda elegir. 
    // Si es Artesano, no enviamos nada o solo su propio registro.
    $artesanos = $user->hasRole('Admin') 
        ? Proveedor::with('persona')->get() 
        : collect(); 

    $categorias = Categoria::with('caracteristica')->get();
    $presentaciones = Presentaciones::with('caracteristica')->get();

    return view('productos.create', compact('artesanos', 'categorias', 'presentaciones'));
}

    public function store(Request $request)
{
    // 1. Validación (Sin marca_id porque ya lo eliminamos)
    $request->validate([
        'nombre' => 'required|string|max:80',
        'precio_artesano' => 'required|numeric|min:0',
        'proveedore_id' => 'required|exists:proveedores,id',
        'categoria_id' => 'required|exists:categorias,id',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'presentacione_id' => 'required|exists:presentaciones,id',
        'stock' => 'required|integer|min:0',
    ]);

    // 2. Seguridad de Rol: Si es Artesano, forzamos que el proveedor sea él mismo
    $user = auth()->user();
    $proveedor_id = $user->hasRole('Artesano') ? $user->id : $request->proveedore_id;
    
    // Obtenemos el artesano para calcular la comisión real
    $artesano = Proveedor::findOrFail($proveedor_id);

    // 3. Gestión de la Imagen
    $path_img = null;
    if($request->hasFile('imagen')){
        $path_img = $request->file('imagen')->store('productos', 'public');
    }

    // 4. Cálculo de Precio Final (Precio Artesano + Comisión del Sistema)
    $precio_final = $request->precio_artesano + $artesano->comision_fija_sistema;

    // 5. Generación de Código Automático
    $codigo_generado = $request->codigo ?? 'ART-' . strtoupper(Str::random(6));

    // 6. Crear el producto
    $producto = Producto::create([
        'codigo' => $codigo_generado,
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'precio_artesano' => $request->precio_artesano,
        'precio_venta' => $precio_final,
        'stock' => $request->stock,
        'estado' => 1,
        'proveedore_id' => $proveedor_id, // Usamos el ID validado por rol
        'presentacione_id' => $request->presentacione_id,
        'medida' => $request->medida,
        'img_url' => $path_img,
    ]);

    // 7. Relación en tabla pivote (Categorías)
    $producto->categorias()->attach($request->categoria_id);

    // 8. Redirección a la ruta con el nuevo NAMESPACE (artesano.productos.index)
    return redirect()->route('artesano.productos.index')
        ->with('success', "Producto '{$producto->nombre}' creado con código: {$producto->codigo}");
}

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
{
    // Cargamos relaciones: artesano, persona del artesano y las categorías
    $producto->load(['artesano.persona', 'categorias.caracteristica']);
    
    return view('productos.show', compact('producto'));
}

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Producto $producto)
{
    $user = auth()->user();
    
    // SEGURIDAD: Si no es Admin y el producto no le pertenece, bloqueamos
    if (!$user->hasRole('Admin') && $producto->user_id !== $user->id) {
        abort(403, 'No tienes permiso para editar este producto.');
    }

    $artesanos = Proveedor::with('persona')->get();
    $categorias = Categoria::with('caracteristica')->get();
    
    $presentaciones = Presentaciones::with('caracteristica')->get();

    $categoria_id = $producto->categorias->first()?->id;

    return view('productos.create', compact('producto', 'artesanos', 'categorias',  'presentaciones', 'categoria_id'));
}
    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request, string $id)
{
    $producto = Producto::findOrFail($id);
    $user = auth()->user();

    // 1. SEGURIDAD: Validar que el usuario tiene permiso sobre este registro específico
    if (!$user->hasRole('Admin') && $producto->proveedore_id !== $user->id) {
        abort(403, 'Acción no autorizada.');
    }

    // 2. Validación (sin marcas)
    $request->validate([
        'nombre' => 'required|string|max:80',
        'precio_artesano' => 'required|numeric|min:0',
        'proveedore_id' => 'required|exists:proveedores,id',
        'categoria_id' => 'required|exists:categorias,id',
        'presentacione_id' => 'required|exists:presentaciones,id',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 3. Preparar datos
    $data = $request->except(['imagen', 'codigo']); // El código no debería cambiar al editar

    // Forzar el proveedor si es artesano (evita que cambie el dueño vía inspección de elemento)
    if ($user->hasRole('Artesano')) {
        $data['proveedore_id'] = $user->id;
    }

    // 4. Gestionar la Imagen
    if ($request->hasFile('imagen')) {
        if ($producto->img_url && \Storage::disk('public')->exists($producto->img_url)) {
            \Storage::disk('public')->delete($producto->img_url);
        }
        $data['img_url'] = $request->file('imagen')->store('productos', 'public');
    }

    // 5. Recalcular el Precio de Venta (Seguridad en el servidor)
    $artesano = Proveedor::findOrFail($data['proveedore_id']);
    $data['precio_venta'] = $request->precio_artesano + $artesano->comision_fija_sistema;

    // 6. Actualizar Producto
    $producto->update($data);

    // 7. Sincronizar Categorías (Tabla Pivote)
    $producto->categorias()->sync([$request->categoria_id]);

    // 8. Redirección a la ruta organizada
    return redirect()->route('artesano.productos.index')
        ->with('success', "El producto '{$producto->nombre}' se actualizó correctamente.");
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
{
    try {
        $producto = Producto::findOrFail($id);
        $user = auth()->user();

        // --- SEGURIDAD DE ROL ---
        // Si no es Admin Y el producto no pertenece al artesano logueado, bloqueamos.
        // Nota: Asegúrate de que el campo sea 'proveedore_id' o 'user_id' según tu DB.
        if (!$user->hasRole('Admin') && $producto->proveedore_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para eliminar este producto.'
            ], 403);
        }

        // 1. Borrar la imagen física del storage si existe
        // Usamos la fachada \Storage para evitar errores de importación
        if ($producto->img_url && \Storage::disk('public')->exists($producto->img_url)) {
            \Storage::disk('public')->delete($producto->img_url);
        }

        // 2. Eliminar relaciones en la tabla pivote (categoria_producto)
        // El método detach() limpia la tabla intermedia sin borrar la categoría
        $producto->categorias()->detach();

        // 3. Eliminar el registro de la base de datos
        $producto->delete();

        return response()->json([
            'success' => true,
            'message' => '¡El producto y sus archivos han sido eliminados!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error técnico al eliminar: ' . $e->getMessage()
        ], 500);
    }
}
}