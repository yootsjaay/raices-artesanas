<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $fillable = [
        'codigo', 
        'nombre', 
        'descripcion', 
        'precio_artesano', // Agregado: necesario para tu lógica de costos
        'precio_venta',    // Agregado: necesario para el PVP
        'stock', 
        'img_url', 
        'medida', 
        'estado', 
        'proveedore_id',   // Agregado: relación con el artesano
        'marca_id', 
        'presentacione_id'
    ];

    // Relación: Un producto pertenece a un artesano (Proveedor)
    public function artesano()
    {
        return $this->belongsTo(Proveedor::class, 'proveedore_id');
    }

    // Relación: Un producto pertenece a una marca
    public function marca()
    {
        return $this->belongsTo(Marcas::class);
    }

    // Relación: Un producto tiene una presentación
    public function presentacion()
    {
        return $this->belongsTo(Presentaciones::class, 'presentacione_id');
    }

    // Relación Muchos a Muchos con Categorías
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto', 'producto_id', 'categoria_id');
    }

    // NUEVA RELACIÓN: Para las 10 imágenes de la galería
    public function imagenes()
    {
        return $this->hasMany(ProductoImagen::class, 'producto_id');
    }
}