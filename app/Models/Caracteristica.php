<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Caracteristica
 * 
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property bool $estado
 * @property bool $destacado
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Categoria[] $categorias
 * @property Collection|Presentacione[] $presentaciones
 *
 * @package App\Models
 */
class Caracteristica extends Model
{
	protected $table = 'caracteristicas';

	protected $casts = [
		'estado' => 'bool',
		'destacado' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'descripcion',
		'estado',
		'destacado'
	];

	public function categorias()
	{
		return $this->hasMany(Categoria::class, 'caracteristicas_id');
	}

	public function presentacione()
	{
		return $this->hasMany(Presentacione::class, 'caracteristicas_id');
	}
}
