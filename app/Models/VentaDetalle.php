<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    protected $table = 'venta_detalles';

    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'comision_aplicada'
    ];

    /**
     * Relación: El detalle pertenece a una venta
     */
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    /**
     * Relación: El detalle se refiere a un producto específico
     */
    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}