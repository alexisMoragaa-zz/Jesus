<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CaptacionesExitosa extends Model {
      
	  
	protected $table = 'captaciones_exitosas';

	//
	protected $fillable = ['n_interno_dues', 'id_interno_funda','origen', 'fono1',
	'fono2','fono3','fono4','nombre','apellido','otro_antecedente','correo1','correo2','fecha_firma_inscripcion','otro_antecedente','monto_original','monto_aporte','monto_final',
	'estado','fecha_volver_allamar','fecha_volver_allamar','mensaje','observacion','n_llamados','fecha_primer_llamado','fecha_segundo_llamado','fecha_tercer_llamado'
	];
}
