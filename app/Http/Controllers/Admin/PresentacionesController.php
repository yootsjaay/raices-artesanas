<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Presentaciones;
use App\Models\Caracteristica;
use App\Http\Requests\StorePresentacionRequest;
use App\Http\Requests\UpdatePresentacionRequest;
use Illuminate\Support\Facades\DB;

class PresentacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presentaciones= Presentaciones::with('caracteristica')->get();;
        return view('presentaciones.index', ['presentaciones' => $presentaciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $presentaciones=Presentaciones::create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePresentacionRequest $request)
    {
        try {
            DB::beginTransaction();

            // Crear la característica
            $caracteristica = Caracteristica::create($request->validated());

            // Crear la presentación asociada
            $caracteristica->presentacione()->create([
                'caracteristica_id' => $caracteristica->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Presentación registrada con éxito.',
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la presentación: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
   public function show($id)
{
    $presentacion = Presentaciones::with('caracteristica')->find($id);

    if (!$presentacion) {
        return response()->json([
            'success' => false,
            'message' => 'Presentación no encontrada'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $presentacion,
    ]);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

   public function update(UpdatePresentacionRequest $request, $id)
{   


    try {
        DB::beginTransaction();

        $presentacion = Presentaciones::with('caracteristica')->findOrFail($id);

        if (!$presentacion->caracteristica) {
            return response()->json([
                'success' => false,
                'message' => 'Característica no encontrada.'
            ], 404);
        }

        $presentacion->caracteristica->update(
            $request->validated()
        );

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Presentación actualizada con éxito.',
            'data' => $presentacion->caracteristica,
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar la presentación: ' . $e->getMessage(),
        ], 500);
    }
}


    public function destroy(string $id)
{
    $presentacion = Presentaciones::with('caracteristica')->find($id);

    if (!$presentacion) {
        return response()->json([
            'success' => false,
            'message' => 'Presentación no encontrada.',
        ], 404);
    }

    if (!$presentacion->caracteristica) {
        return response()->json([
            'success' => false,
            'message' => 'Característica no encontrada.',
        ], 404);
    }

    $estadoActual = $presentacion->caracteristica->estado;

    $presentacion->caracteristica->update([
        'estado' => $estadoActual == 1 ? 0 : 1
    ]);

    return response()->json([
        'success' => true,
        'message' => $estadoActual == 1 
            ? 'Presentación eliminada correctamente.' 
            : 'Presentación restaurada correctamente.',
        'action' => $estadoActual == 1 ? 'eliminar' : 'restaurar',
    ]);
}
}
