<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategorias extends FormRequest
{
    /**
     * Autoriza la petición
     */
    public function authorize(): bool
    {
        return true; // o lógica de permisos si luego te pones fino
    }

    /**
     * Reglas de validación
     */
        public function rules(): array
        {
            return [
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string', // Cambia 'required' por 'nullable'
                'destacado' => 'nullable|boolean',
                
            ];
        }
}
