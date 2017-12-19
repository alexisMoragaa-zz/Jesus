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


    }
}
