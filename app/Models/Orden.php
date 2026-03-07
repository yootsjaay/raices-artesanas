<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'ordenes';

    protected $fillable = [
        'user_web_id', 'codigo_orden', 'subtotal', 'costo_envio', 
        'comision_sistema', 'monto_total', 'estado'
    ];

    // Relación: Qué productos se compraron en esta orden
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'orden_productos')
                    ->withPivot('cantidad', 'precio_unitario');
    }

    // Relación: Datos del envío (Aquí es donde conectarás envia.com)
    public function envio()
    {
        return $this->hasOne(Envio::class, 'orden_id');
    }
}