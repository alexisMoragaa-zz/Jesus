<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class captaciones extends Model
{

    protected $table = 'captaciones';

    /**
     *este modelo mal llamado captaciones se encarga de gestionar los registros de llamado.
     * es decir este modelo se encarga de los registros recividos por la fundacion y son los registros que ams adelante
     * llamaran los teleoperadores
     */
    protected $fillable = ['campana', 'estado_registro', 'nom_fundacion', 'n_dues', 'id_fundacion', 'fono_1', 'fono_2', 'fono_3', 'fono_4', 'nombre', 'apellido', 'correo_1', 'correo2',
        'firma_inscripcion', 'otro_antecedente', 'monto', 'estado', 'fecha_volver_llamar', 'mensaje',
        'observacion', 'n_llamados', 'primer_llamado', 'segundo_llamado', 'tercer_llamado'];

    protected $hidden = [];

}
