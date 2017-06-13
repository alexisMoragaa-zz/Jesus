<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

/**
*este es el modelo demusuario.
 * esta encarghado de gestionar la informacion de los usuarios que utilizaran el webside
 */
	protected $table = 'users';


	protected $fillable = ['name', 'email','perfil','estado', 'password','campana','turno', 'fecha_ingreso', 'fecha_termino'];
							/*campos que podemos modificar*/


	protected $hidden = ['password', 'remember_token'];
							/*campos que no podemoa modificar*/

	
	/**
	 * esta funcion se encarga de gestional la relacion muchos a muchos entre usuarios y campañas
	 * ademas de incluir campos adicionales a la tabla pivote
	 */
	public function campanitas()
{
	return $this->belongsToMany(Campana::class)
		->withPivot('fecha_inicio')
		->withPivot('fecha_termino')
		->withPivot('motivo_termino')
		->withTimestamps();
}

	
}