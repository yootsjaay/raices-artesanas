<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePresentacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
        'nombre' => 'required|max:60|unique:caracteristicas,nombre,' . $this->id,
            'descripcion' => 'nullable|max:255',
            'destacado' => 'nullable|boolean',
        ];
    }
}
