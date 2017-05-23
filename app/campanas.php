<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class campanas extends Model
{

    //


    protected $table = 'campanas';


    protected $filable = ['nombre_campana', 'id_campana' ,'ubicacion','fundacion'];


    protected $hidden = [];
}