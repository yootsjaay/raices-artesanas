<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'user_id',
        'tipo_persona',
        'nombre',
        'apellido',
        'telefono',
        'direccion',
        'municipio',
        'comunidad',
        'estado',
        'nombre_taller',
        'biografia',
    ];

    // Relación inversa: Esta persona PERTENECE a un Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}