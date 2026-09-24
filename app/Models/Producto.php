<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 * 
 * @property int $id
 * @property string $codigo
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $stock
 * @property string|null $img_url
 * @property string|null $medida
 * @property int $estado
 * @property float $peso
 * @property float $largo
 * @property float $ancho
 * @property float $alto
 * @property bool $es_fragil
 * @property float $precio_artesano
 * @property float $precio_venta
 * @property int $persona_id
 * @property int $presentacione_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Presentacione $presentacione
 * @property Persona $persona
 * @property Collection|Categoria[] $categorias
 * @property Collection|VentaDetalle[] $venta_detalles
 *
 * @package App\Models
 */
class Producto extends Model
{
    protected $table = 'productos';

    protected $casts = [
        'stock' => 'int',
        'estado' => 'int',
        'precio_artesano' => 'float',
        'precio_venta' => 'float',
        'persona_id' => 'int',
        'presentacione_id' => 'int',
        // Nuevos casts para logística
        'peso' => 'float',
        'largo' => 'float',
        'ancho' => 'float',
        'alto' => 'float',
        'es_fragil' => 'boolean'
    ];

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'stock',
        'img_url',
        'medida',
        'estado',
        'precio_artesano',
        'precio_venta',
        'persona_id',
        'presentacione_id',
		// Nuevos campos para logística
        'peso',
        'largo',
        'ancho',
        'alto',
        'es_fragil'
    ];

    // --- RELACIONES ---

    public function presentacione()
    {
        return $this->belongsTo(Presentacione::class);
    }

    /**
     * Relación con el Artesano (Persona)
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class)
                    ->withPivot('id')
                    ->withTimestamps();
    }

    public function venta_detalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    // --- MÉTODOS DE AYUDA (Helpers) ---

    /**
     * Retorna el peso con su unidad para mostrar en la vista
     */
    public function getPesoFormateadoAttribute()
    {
        return "{$this->peso} kg";
    }

    /**
     * Retorna las dimensiones en formato string
     */
    public function getDimensionesAttribute()
    {
        return "{$this->largo}x{$this->ancho}x{$this->alto} cm";
    }
}