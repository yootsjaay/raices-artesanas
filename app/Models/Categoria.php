<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Categoria
 * 
 * @property int $id
 * @property int $caracteristicas_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Caracteristica $caracteristica
 * @property Collection|Producto[] $productos
 *
 * @package App\Models
 */
class Categoria extends Model
{
	protected $table = 'categorias';

	protected $casts = [
		'caracteristicas_id' => 'int'
	];

	protected $fillable = [
		'caracteristicas_id'
	];

	public function caracteristica()
	{
		return $this->belongsTo(Caracteristica::class, 'caracteristicas_id');
	}

	public function productos()
	{
		return $this->belongsToMany(Producto::class)
					->withPivot('id')
					->withTimestamps();
	}
}
