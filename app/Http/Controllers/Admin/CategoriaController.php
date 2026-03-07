<?php

namespace App\Http\Controllers\Admin; 
use App\Http\Controllers\Controller;

use App\Models\Categoria;
use App\Models\Caracteristica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCategorias; //
use Exception;

class CategoriaController extends Controller
{
    /**
     * Muestra el listado de categorías.
     */
    public function index()
    {
        // Cargamos la relación 'caracteristica' que usas en tu @foreach
        $categorias = Categoria::with('caracteristica')->get();
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Almacena una nueva categoría.
     */
    public function store(StoreCategorias $request)
    {
        try {
            DB::beginTransaction();

            // 1. Crear la característica primero
           $caracteristica = Caracteristica::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'destacado' => $request->input('destacado', 0), // Por defecto, será 0 si no está marcado
                'estado'=>1,
                ]);

            // 2. Crear la categoría asociada
         Categoria::create([
    'caracteristicas_id' => $caracteristica->id // <--- Agregada la 's' según tu error SQL
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Categoría creada con éxito.']);
            
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al guardar: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Obtiene los datos de una categoría (para el modal de edición).
     */
    public function show($id)
    {
        $categoria = Categoria::with('caracteristica')->find($id);

        if (!$categoria) {
            return response()->json(['success' => false, 'message' => 'No encontrada'], 404);
        }

        return response()->json(['success' => true, 'data' => $categoria]);
    }

    /**
     * Actualiza la categoría.
     */
    public function update(Request $request, $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            
            $categoria->caracteristica->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'destacado' => $request->destacado //
            ]);

            return response()->json(['success' => true, 'message' => 'Categoría actualizada correctamente.']);
            
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar.'], 500);
        }
    }

    /**
     * Alterna el estado (Eliminar/Restaurar).
     */
    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $caracteristica = $categoria->caracteristica;

            // Cambiamos el estado: si es 1 pasa a 0, si es 0 pasa a 1
            $nuevoEstado = ($caracteristica->estado == 1) ? 0 : 1;
            $caracteristica->update(['estado' => $nuevoEstado]);

            $mensaje = ($nuevoEstado == 1) ? 'Categoría restaurada.' : 'Categoría eliminada.';

            return response()->json(['success' => true, 'message' => $mensaje]);
            
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error en la operación.'], 500);
        }
    }
}