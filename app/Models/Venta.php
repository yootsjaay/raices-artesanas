<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Venta
 * 
 * @property int $id
 * @property int $user_id
 * @property float $total
 * @property float $monto_artesano
 * @property float $comision_plataforma
 * @property float $monto_transporte
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|VentaDetalle[] $venta_detalles
 *
 * @package App\Models
 */
class Venta extends Model
{
	protected $table = 'ventas';

	protected $casts = [
		'user_id' => 'int',
		'total' => 'float',
		'monto_artesano' => 'float',
		'comision_plataforma' => 'float',
		'monto_transporte' => 'float'
	];

	protected $fillable = [
		'user_id',
		'total',
		'monto_artesano',
		'comision_plataforma',
		'monto_transporte'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function venta_detalles()
	{
		return $this->hasMany(VentaDetalle::class);
	}
}
