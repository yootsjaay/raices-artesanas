<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $fillable = [
        'orden_id',
        'metodo_envio_id',
        'transportista_id',
        'tracking_number', // Aquí guardarás el ID de envia.com
        'label_url',       // URL del PDF de la guía
        'costo_envio',
        'estado_logistico'
    ];

    // Relación con la orden de compra
    public function orden()
    {
        return $this->belongsTo(Orden::class);
    }

    // Relación con el método (DHL, Taxi, etc.)
    public function metodo()
    {
        return $this->belongsTo(MetodoEnvio::class, 'metodo_envio_id');
    }

    // Relación opcional: Solo si el envío es por Taxi/Urbano
    public function transportista()
    {
        return $this->belongsTo(Transportista::class);
    }
}