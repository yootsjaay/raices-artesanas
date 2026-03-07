<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['caracteristicas_id'];

    // Relación: La categoría obtiene su nombre y estado de "caracteristicas"
    public function caracteristica()
    {
        // Si en tu migración usaste 'caracteristicas_id', ponlo aquí:
        return $this->belongsTo(Caracteristica::class, 'caracteristicas_id');
    }

    // Relación Muchos a Muchos: Una categoría tiene muchos productos
    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'categoria_producto');
    }
}