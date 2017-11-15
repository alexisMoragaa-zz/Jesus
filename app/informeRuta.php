<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class informeRuta extends Model {


protected $table='informe_rutas';

protected $fillable=['id_captacion','id_ruta','fecha_agendamiento','estado','num_retiro',
                      'comuna','rutero','horario',];

public function cap(){
  return $this->belongsTo(CaptacionesExitosa::class,'id_captacion','id');
}

public function Ruta(){
  return  $this->belongsTo(estadoRuta::class,'id_ruta','id');
}

}
