<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores'; // Laravel a veces busca "proveedors", mejor especificarlo

    protected $fillable = [
        'persona_id', 
        'nombre_taller', 
        'biografia_artesano', 
        'comision_fija_sistema'
    ];

    // Relación 1 a 1: El artesano tiene sus datos personales en la tabla Personas
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    // Relación 1 a Muchos: Un artesano puede tener muchas artesanías (productos)
    public function productos()
    {
        return $this->hasMany(Producto::class, 'proveedore_id'); 
    }
}