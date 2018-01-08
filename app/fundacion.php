<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class fundacion extends Model {


      protected $table ='fundacions';

  public function misCampanas(){
    return $this->hasMany(Campana::class,'fundacion','id');
  }

  public function myLetters(){
    return $this->hasMany(Letter::class,'id_fundacion','id');
  }

}
