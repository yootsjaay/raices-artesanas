<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ordene
 * 
 * @property int $id
 * @property string $numero_pedido
 * @property int $user_id
 * @property float $subtotal
 * @property float $costo_envio
 * @property float $comision_sistema
 * @property float $total
 * @property string $estado_pago
 * @property string $estado_envio
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|Envio[] $envios
 *
 * @package App\Models
 */
class Ordene extends Model
{
	protected $table = 'ordenes';

	protected $casts = [
		'user_id' => 'int',
		'subtotal' => 'float',
		'costo_envio' => 'float',
		'comision_sistema' => 'float',
		'total' => 'float'
	];

	protected $fillable = [
		'numero_pedido',
		'user_id',
		'subtotal',
		'costo_envio',
		'comision_sistema',
		'total',
		'estado_pago',
		'estado_envio'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function envios()
	{
		return $this->hasMany(Envio::class, 'orden_id');
	}
}
