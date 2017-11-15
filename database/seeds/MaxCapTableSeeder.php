<?php

use Illuminate\Database\Seeder;


class MaxCapTableSeeder extends Seeder
{

    /*seeder paera agragar un usuario de tipo administrador*/
    public function run()
    {
        \DB::table('max_caps')->insert(array(
            'maxDay'=>'8',
            'maxAm'=>'4',
            'maxPm'=>'4',
            'passcode'=>"",

        ));


    }
}
