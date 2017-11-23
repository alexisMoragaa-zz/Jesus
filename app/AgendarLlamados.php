<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendarLlamados extends Model {

	protected $table= 'agendar_llamados';

  protected $fillable=['id_llamdo','teleoperador','fecha_llamado','estado_llamado',];

public function llamadosAgendados(){
  return $this->belongsTo(captaciones::class,'id_llamado','id');
}

public function teo_agenda(){
  return $this->belongsTo(User::class,'teleoperador','id');
}
}
