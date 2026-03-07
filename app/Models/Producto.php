<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
   protected $fillable = [
    'codigo', 
    'nombre', 
    'descripcion', 
    'stock', 
    'img_url', 
    'medida', 
    'precio_artesano', 
    'precio_venta', 
    'proveedore_id', 
    'marca_id', 
    'presentacione_id', 
    'estado'
];
    // Relación: Quién hizo esta artesanía
    public function artesano()
    {
        return $this->belongsTo(Proveedor::class, 'proveedore_id');
    }

    // Relación Muchos a Muchos: Categorías (Textiles, Barro, etc.)
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto');
    }

    // Relación: Su marca (si aplica) o presentación
    public function presentacion()
    {
        return $this->belongsTo(Presentacione::class, 'presentacione_id');
    }
}