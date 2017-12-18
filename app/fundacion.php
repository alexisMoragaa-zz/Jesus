<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class fundacion extends Model {


      protected $table ='fundacions';

  public function misCampanas(){
    return $this->hasMany(Campana::class,'fundacion','id');
  }

}
