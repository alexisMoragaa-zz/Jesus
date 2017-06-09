<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;


	protected $table = 'users';


	protected $fillable = ['name', 'email','perfil','estado', 'password','campana','turno', 'fecha_ingreso', 'fecha_termino'];


	protected $hidden = ['password', 'remember_token'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
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