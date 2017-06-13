<?php

use Illuminate\Database\Seeder;


class CampanaTableSeeder extends Seeder
{
    
    /*seeder para agragar campañas al sistema*/
    public function run()
    {
        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'Ballenas RM',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'Greepneace'
        ));

        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'Ballenas OR',
            'ubicacion'=>'REGIONES',
            'fundacion'=>'Greepneace'
        ));

        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'FB ALIVE',
            'ubicacion'=>'REGION METROPOLITANA',
            'fundacion'=>'AMNISTIA INTERNACIONAL'
        ));

        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'TIBIA 4',
            'ubicacion'=>'MIXTA',
            'fundacion'=>'WWF'
        ));

        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'OCEANOS',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'Greepneace'
        ));

        \DB::table('campanas')->insert(array(
            'nombre_campana'=>'GLACIARES',
            'ubicacion'=>'region metropolitana',
            'fundacion'=>'Greepneace'
        ));
    }
}

