<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Campana extends Model
{

    //
    /*
     * Este es el modelo de Campañas.
     * desde el modelo podemos espesificar que campos podemos modificar desde nuestra aplicacion y cuales campos
     * por otro lado estahn protegidos y no se pueden editar
     * */

    protected $table = 'campanas';//nombre de la tabla que se creara con al migracion


    protected $filable = ['nombre_campana', 'ubicacion', 'fundacion'];//campos que podemos editar


    protected $hidden = [];//campos que no podemos editar

    /**
     * funcion encargada de generar la relacion muchos a muchos con usuarios
     * con esta funcion le decimos que una campaña puede tener muchos usuarios
     * ademas agregamos algunos campos adicionales  a la tabla pivote que es la
     * encargada de gestionar la relacion muchos a muchos
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('fecha_inicio')
            ->withPivot('fecha_termino')
            ->withPivot('motivo_termino')
            ->withTimestamps();
    }
}