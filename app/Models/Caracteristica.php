<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    protected $table = 'caracteristicas'; // Aseguramos el nombre de la tabla
    protected $fillable = ['nombre', 'estado'];

    // Relación con Categoría
    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'caracteristicas_id');
    }

    // Relación con Marcas
    public function marca()
    {
        return $this->hasOne(Marcas::class, 'caracteristicas_id');
    }

    // Relación con Presentaciones
    public function presentacione()
    {
        return $this->hasOne(Presentaciones::class, 'caracteristicas_id');
    }
}