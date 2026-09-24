<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VentaDetalle
 * 
 * @property int $id
 * @property int $venta_id
 * @property int $producto_id
 * @property int $cantidad
 * @property float $precio_unitario
 * @property float $comision_aplicada
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Producto $producto
 * @property Venta $venta
 *
 * @package App\Models
 */
class VentaDetalle extends Model
{
	protected $table = 'venta_detalles';

	protected $casts = [
		'venta_id' => 'int',
		'producto_id' => 'int',
		'cantidad' => 'int',
		'precio_unitario' => 'float',
		'comision_aplicada' => 'float'
	];

	protected $fillable = [
		'venta_id',
		'producto_id',
		'cantidad',
		'precio_unitario',
		'comision_aplicada'
	];

	public function producto()
	{
		return $this->belongsTo(Producto::class);
	}

	public function venta()
	{
		return $this->belongsTo(Venta::class);
	}
}
