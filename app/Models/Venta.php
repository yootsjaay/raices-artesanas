<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'monto_artesano',
        'comision_plataforma',
        'monto_transporte'
    ];

    /**
     * Relación: Una venta tiene muchos detalles (productos vendidos)
     */
    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class, 'venta_id');
    }

    /**
     * Relación: Una venta fue registrada por un usuario (vendedor/admin)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Boot method para lógica automática (Opcional)
     * Por ejemplo, podrías generar un folio automático antes de crear la venta.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($venta) {
            // Lógica para asignar folios o validar montos antes de guardar
        });
    }
}