<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Campana extends Model
{

    //


    protected $table = 'campanas';


    protected $filable = ['nombre_campana' ,'ubicacion','fundacion'];


    protected $hidden = [];

 public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('fecha_inicio')
            ->withPivot('fecha_termino')
            ->withPivot('motivo_termino')
            ->withTimestamps();
    }
}