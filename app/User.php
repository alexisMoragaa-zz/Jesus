<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;


    protected $table = 'users';


    protected $fillable = ['name', 'last_name', 'rut', 'dv', 'perfil', 'email', 'direccion', 'telefono', 'afp', 'previcion', 'nombre_isapre',
        'turno', 'estado', 'fecha_nacimiento', 'tipo_cuenta', 'n_cuenta', 'campana', 'fecha_ingreso', 'fecha_termino', 'password'];

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
            ->withPivot('created_at')
            ->withPivot('updated_at')
            ->withPivot('id')
            ->withTimestamps();
    }

    public function captacion()
    {

        return $this->hasMany(CaptacionesExitosa::class);
    }


}