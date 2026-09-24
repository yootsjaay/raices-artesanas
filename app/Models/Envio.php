<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Envio
 * 
 * @property int $id
 * @property int $orden_id
 * @property string $metodo
 * @property string|null $tracking_number
 * @property string|null $url_etiqueta
 * @property string|null $detalles_entrega
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Ordene $ordene
 *
 * @package App\Models
 */
class Envio extends Model
{
	protected $table = 'envios';

	protected $casts = [
		'orden_id' => 'int'
	];

	protected $fillable = [
		'orden_id',
		'metodo',
		'tracking_number',
		'url_etiqueta',
		'detalles_entrega'
	];

	public function ordene()
	{
		return $this->belongsTo(Ordene::class, 'orden_id');
	}
}
