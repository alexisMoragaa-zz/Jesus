<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CaptacionesExitosa extends Model
{
    /**
     *este modelo es el responsable de gestionar la informacionn de los "cluientes que aceptan ser socios de una fundacion
     * una vez que esto ocurre viaja la informacion de el modelo captaciones y se añade informacion adicional como la
     * direccion entre otros datos necesaris para lso agendamientos.
     */

    protected $table = 'captaciones_exitosas';

    //
    protected $fillable = ['n_dues', 'id_fundacion', 'nom_campana', 'fecha_captacion', 'fecha_agendamiento', 'tipo_retiro', 'jornada', 'horario',
        'nombre', 'apellido', 'rut', 'direccion', 'comuna', 'ciudad', 'region', 'fono_1', 'correo_1', 'observaciones',
        'rutero', 'teleoperador', 'fundacion', 'monto', 'estado', 'forma_pago', 'user_id','cuenta_movistar','originalTeo','letter' ];


    public function user()
    {
        return $this->belongsTo(User::class,'teleoperador');
    }

    public function estadoRuta()
    {
        return $this->hasOne(estadoRuta::class,'id','id');
    }

    public function info_ruta()
    {
        return $this->hasMany(informeRuta::class,'id_captacion');
    }

    public function myLetter(){
      return $this->belongsTo(Letter::class,'letter');
    }


}
