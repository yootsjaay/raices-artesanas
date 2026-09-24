<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Persona
 * 
 * @property int $id
 * @property int $user_id
 * @property string $tipo_persona
 * @property string $nombre
 * @property string $apellido
 * @property string|null $telefono
 * @property string|null $direccion
 * @property string $municipio
 * @property string|null $comunidad
 * @property int $estado
 * @property string|null $nombre_taller
 * @property string|null $biografia
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|Proveedore[] $proveedores
 * @property Collection|Transportista[] $transportistas
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Persona extends Model
{
	protected $table = 'personas';

	protected $casts = [
		'user_id' => 'int',
		'estado' => 'int'
	];

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
		'biografia'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function persona()
	{
		return $this->hasMany(Proveedore::class);
	}

	public function transportistas()
	{
		return $this->hasMany(Transportista::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
