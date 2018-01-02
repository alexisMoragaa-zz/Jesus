<?php

use Illuminate\Database\Seeder;


class CampanaTableSeeder extends Seeder
{

    /*seeder para agragar campañas al sistema*/
    public function run()
    {
        // \DB::table('campanas')->insert(array(
        //     'nombre_campana'=>'Sin Campaña',
        //     'ubicacion'=>'Sin Region',
        //     'fundacion'=>'Sin Fundacion'
        // ));
        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'Magallanes RM',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'1',
        ));
        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'Leones Marinos',
            'ubicacion'=>'Regiones',
            'fundacion'=>'1',
        ));
        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'Vida',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'2',
        ));
        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'Hermanos',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'3',
        ));
        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'Somos uno',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'3',
        ));


    }
}
