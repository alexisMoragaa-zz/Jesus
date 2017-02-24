<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class campana extends Model {

    /*ESTE MODELO ESTA ENCARGADO DE ADMINISTRAR LA SUBIDA DE LAS CAMPAÑAS, Y RESTRINGIR LOS CAMPOS
        QUE NO PUEDEN SER MODIFICADOS */

    protected $table = 'campanas';

    protected $fillable = ['n_interno_dues', 'id_interno_funda','origen', 'fono1',
        'fono2','fono3','fono4','nombre','apellido','otro_antecedente','correo1','correo2','fecha_firma_inscripcion','otro_antecedente','monto_original','monto_aporte','monto_final',
        'estado','fecha_volver_allamar','fecha_volver_allamar','mensaje','observacion','n_llamados','fecha_primer_llamado','fecha_segundo_llamado','fecha_tercer_llamado'
    ];

    /*Campos Protegidos (no modificables)*/
   // protected $hidden = ['num_dues','id_fundacion','origen','fecha_firma_iscripcion'];



}
