<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = ['tipo_documento'];

    // Relación: Un tipo de documento (ej. INE) lo pueden tener muchas personas
    public function personas()
    {
        return $this->hasMany(Persona::class);
    }
}