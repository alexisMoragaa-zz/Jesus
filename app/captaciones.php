<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class captaciones extends Model {

    protected $table = 'captaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['n_dues', 'id_fundacion','fono_1','fono_2','fono_3','fono_4','nombre','apellido','otro_antecedente','correo_1','correo2',
                           'firma_inscripcion','otro_antecedente','monto','estado','fecha_volver_llamar','fecha_volver_allamar','mensaje',
                           'observacion','n_llamados','primer_llamado','segundo_llamado','tercer_llamado' ];

    protected $hidden = [];

}
