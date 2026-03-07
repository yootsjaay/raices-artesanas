<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoEnvio extends Model
{
    // Especificamos el nombre de la tabla porque Laravel buscaría "metodo_envios"
    protected $table = 'metodo_envios';

    protected $fillable = [
        'nombre', 
        'tipo', // 'local' o 'plataforma_api'
        'tarifa_base',
        'descripcion',
        'punto_recepcion'
    ];

    // Relación: Un método de envío puede aparecer en muchos registros de envío
    public function envios()
    {
        return $this->hasMany(Envio::class, 'metodo_envio_id');
    }

    /**
     * Función útil para tu lógica de negocio:
     * Verifica si este método debe conectarse a envia.com
     */
    public function esExterno()
    {
        return $this->tipo === 'plataforma_api';
    }
}