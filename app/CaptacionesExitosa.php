<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CaptacionesExitosa extends Model {
      
	  
	protected $table = 'captaciones_exitosas';

	//
	protected $fillable = ['n_dues', 'id_fundacion','nom_campana','fecha_captacion','fecha_agendamiento','tipo_retiro', 'jornada','horario',
							'nombre','apellido', 'rut','dv','direccion','comuna','ciudad','region','fono_1','correo_1','observaciones',
							'rutero','teleoperador','fundacion','monto','estado','forma_pago'
	];
}
