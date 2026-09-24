<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoriaProducto
 * 
 * @property int $id
 * @property int $categoria_id
 * @property int $producto_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Categoria $categoria
 * @property Producto $producto
 *
 * @package App\Models
 */
class CategoriaProducto extends Model
{
	protected $table = 'categoria_producto';

	protected $casts = [
		'categoria_id' => 'int',
		'producto_id' => 'int'
	];

	protected $fillable = [
		'categoria_id',
		'producto_id'
	];

	public function categoria()
	{
		return $this->belongsTo(Categoria::class);
	}

	public function producto()
	{
		return $this->belongsTo(Producto::class);
	}
}
