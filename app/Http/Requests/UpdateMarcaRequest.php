<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarcaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    // Obtenemos el ID de la ruta (ajusta 'id' o 'marca' según tu Route::patch)
    $marcaId = $this->route('marca') ?? $this->route('id');

    return [
        // La regla unique ahora ignorará el nombre de esta marca específica
        'nombre' => 'required|max:60|unique:caracteristicas,nombre,' . $marcaId . ',id',
        'descripcion' => 'nullable|max:255',
        'destacado' => 'nullable|boolean',
    ];
}
}