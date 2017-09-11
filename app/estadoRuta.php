<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class estadoRuta extends Model {
    
    protected $table ='estado_rutas';

	//

    protected $fillable=['primer_agendamiento'];





    public function agendamiento(){

        return $this->belongsTo(CaptacionesExitosa::class,'id');
    }
}
