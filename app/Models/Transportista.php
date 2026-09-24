<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transportista
 * 
 * @property int $id
 * @property int $persona_id
 * @property string $tipo_unidad
 * @property string|null $numero_unidad
 * @property string $ruta_principal
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Persona $persona
 *
 * @package App\Models
 */
class Transportista extends Model
{
	protected $table = 'transportistas';

	protected $casts = [
		'persona_id' => 'int'
	];

	protected $fillable = [
		'persona_id',
		'tipo_unidad',
		'numero_unidad',
		'ruta_principal'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class);
	}
}
