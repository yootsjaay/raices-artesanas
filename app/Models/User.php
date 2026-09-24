<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * Class User
 * 
 * @property int $id
 * @property int|null $persona_id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $img
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Persona|null $persona
 * @property Collection|Ordene[] $ordenes
 * @property Collection|Venta[] $ventas
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	
use HasApiTokens, Notifiable, HasRoles, HasFactory;

protected $table = 'users';

	protected $casts = [
		'persona_id' => 'int',
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'persona_id',
		'name',
		'email',
		'email_verified_at',
		'password',
		'img',
		'remember_token'
	];

	public function persona()
	{
		return $this->hasOne(Persona::class);
	}

	public function ordenes()
	{
		return $this->hasMany(Ordene::class);
	}

	public function ventas()
	{
		return $this->hasMany(Venta::class);
	}
}
