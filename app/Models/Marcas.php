<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marcas extends Model
{
    protected $fillable = ['caracteristicas_id'];

    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class, 'caracteristicas_id');
    }
}