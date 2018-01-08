<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model {

	protected $table='letters';

  public function letterByFoundation()
	{
    return $this->belongsTo(fundacion::class,'id_fundacion','id');
  }

	public function mandatesByLetter()
	{
		return $this->hasMany(CaptacionesExitosa::class,'letter','id');
	}

}
