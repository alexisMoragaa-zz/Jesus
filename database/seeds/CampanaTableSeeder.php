<?php

use Illuminate\Database\Seeder;


class CampanaTableSeeder extends Seeder
{

    /*seeder para agragar campañas al sistema*/
    public function run()
    {
        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'Sin Campaña',
            'ubicacion'=>'Sin Region',
            'fundacion'=>'1'
        ));
        \DB::table('campanas')->insert(array(
            'id'=>'3',
            'nombre_campana'=>'Plasticos RM',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'2',
        ));
        \DB::table('campanas')->insert(array(
            'id'=>'7',
            'nombre_campana'=>'Antartica RM',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'2',
        ));
        \DB::table('campanas')->insert(array(
            'id'=>'8',
            'nombre_campana'=>'Plasticos Or',
            'ubicacion'=>'Regiones',
            'fundacion'=>'2',
        ));
        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'Vida',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'3',
        ));
        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'Hermanos',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'3',
        ));
        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'Somos uno',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'4',
        ));


    }
}
