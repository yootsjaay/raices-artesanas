<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MetodoEnvio
 * 
 * @property int $id
 * @property string $nombre
 * @property string $tipo
 * @property float $tarifa_base
 * @property string|null $punto_recepcion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class MetodoEnvio extends Model
{
	protected $table = 'metodo_envios';

	protected $casts = [
		'tarifa_base' => 'float'
	];

	protected $fillable = [
		'nombre',
		'tipo',
		'tarifa_base',
		'punto_recepcion'
	];
}
