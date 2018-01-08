<?php

use Illuminate\Database\Seeder;


class LetterTableSeeder extends Seeder
{

    /*seeder paera agragar un usuario de tipo administrador*/
    public function run()
    {
        \DB::table('letters')->insert(array(
          'number'=>'0',
          'estado'=>'Carta Transitoria',
          'id_fundacion'=>"1",
        ));

        \DB::table('letters')->insert(array(
          'number'=>'0',
          'estado'=>'Carta Transitoria',
          'id_fundacion'=>"2",
        ));

        \DB::table('letters')->insert(array(
          'number'=>'0',
          'estado'=>'Carta Transitoria',
          'id_fundacion'=>"3",
        ));
        \DB::table('letters')->insert(array(
          'number'=>'0',
          'estado'=>'Carta Transitoria',
          'id_fundacion'=>"4",
        ));
        //
        // \DB::table('letters')->insert(array(
        //   'number'=>'0',
        //   'estado'=>'Carta Transitoria',
        //   'id_fundacion'=>"1",
        // ));
        //
        // \DB::table('letters')->insert(array(
        //   'number'=>'0',
        //   'estado'=>'Carta Transitoria',
        //   'id_fundacion'=>"1",
        // ));







    }
}
