<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $table = 'paquetes';

    protected $fillable = [
        'nombre',
        'peso',
        'largo',
        'ancho',
        'alto',
        'envia_package_id',
        'activo',
    ];

    protected $casts = [
        'peso'   => 'float',
        'largo'  => 'float',
        'ancho'  => 'float',
        'alto'   => 'float',
        'activo' => 'boolean',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}