<?php

use Illuminate\Database\Seeder;


class ComunaTableSeeder extends Seeder
{

    public function run()
    {
      //Comunas Santiago retiro con Agendamientos
        \DB::table('comuna_retiros')->insert(array(

        'region'=>'metropolitana',
        'ciudad'=>'santiago',
        'comuna'=>'Lo Barnechea',
            'lunes'=>'0',
            'rutero'=>'Por Definir',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
    ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Vitacura',
            'rutero'=>'Danko',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'14:30 - 18:00',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'10:00 - 14:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Huechuraba',
            'rutero'=>'Por Definir',
            'lunes'=>'',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Las Condes',
            'rutero'=>'Danko',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'14:30 - 18:00',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'10:00 - 14:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Providencia',
            'rutero'=>'Danko',
            'lunes'=>'1',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'14:30 - 18:00',
            'h_martes'=>'10:00 - 14:00',
            'h_miercoles'=>'14:30 - 18:00',
            'h_jueves' =>'10:00 - 14:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'La Reina',
            'rutero'=>'Danko',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>' 10:00 - 14:00',
            'h_jueves' =>'',
            'h_viernes'=>'10:00 - 14:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Peñalolen',
            'rutero'=>'Danko',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'10:00 - 14:00',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'14:30 - 18:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Ñuñoa',
            'rutero'=>'Danko',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'10:00 - 14:00',
            'h_martes'=>'',
            'h_miercoles'=>'14:30 - 18:00',
            'h_jueves' =>'10:00 - 14:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Macul',
            'rutero'=>'Danko',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'10:00 - 14:00',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'10:00 - 14:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'La Florida',
            'rutero'=>'Danko',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'10:00 - 14:00',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'',
            'h_viernes'=>'14:30 - 18:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Puente Alto',
            'rutero'=>'Danko',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'10:00 - 14:00',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'',
            'h_viernes'=>'14:30 - 18:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'El Bosque',
            'rutero'=>'Daniel',
            'lunes'=>'1',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'14:30 - 18:00',
            'h_martes'=>'10:00 - 14:00',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'14:30 - 18:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'La Pintana',
            'rutero'=>'Danko',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'',
            'h_viernes'=>'14:30 - 18:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'San Joaquin',
            'rutero'=>'Danko',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'10:00 - 14:00',
            'h_martes'=>'',
            'h_miercoles'=>'14:30 - 18:00',
            'h_jueves' =>'',
            'h_viernes'=>'10:00 - 14:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'La Granja',
            'rutero'=>'Danko',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'San Ramon',
            'rutero'=>'Danko',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Santiago',
            'rutero'=>'Daniel',
            'lunes'=>'1',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'10:00 - 14:00',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'14:30 - 18:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Estacion Central',
            'rutero'=>'Daniel',
            'lunes'=>'0',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'14:30 - 18:00',
            'h_jueves' =>'',
            'h_viernes'=>'10:00 - 14:00',

        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Independencia',
            'rutero'=>'Daniel',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'10:00 - 14:00',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'14:30 - 18:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Recoleta',
            'rutero'=>'Daniel',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'1',
            'viernes'=>'',
            'h_lunes'=>'10:00 - 14:00',
            'h_martes'=>'',
            'h_miercoles'=>'14:30 - 18:00',
            'h_jueves' =>'14:30 - 18:00',
            'h_viernes'=>'10:00 - 13:30',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Conchali',
            'rutero'=>'Daniel',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'14:30 - 18:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Quilicura',
            'rutero'=>'Por Definir',
            'lunes'=>'0',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Renca',
            'rutero'=>'Daniel',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Quinta Normal',
            'rutero'=>'Daniel',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'10:00 - 14:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Lo Prado',
            'rutero'=>'Daniel',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'10:00 - 14:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Pudahuel',
            'rutero'=>'Daniel',
            'lunes'=>'0',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'14:30 - 18:00',
            'h_jueves' =>'10:00 - 14:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Cerro Navia',
            'rutero'=>'Daniel',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'10:00 - 14:00',

        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'La Cisterna',
            'rutero'=>'Danko',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'10:00 - 14:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'San Miguel',
            'rutero'=>'Danko',
            'lunes'=>'1',
            'martes'=>'1',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'10:00 - 14:00',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'10:00 - 14:00',
        ));


        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Pedro Aguirre Cerda',
            'rutero'=>'Daniel',
            'lunes'=>'1',
            'martes'=>'1',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'14:30 - 18:00',
            'h_martes'=>'10:00 - 14:00',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'14:30 - 18:00',
        ));


        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Maipu',
            'rutero'=>'Daniel',
            'lunes'=>'0',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'14:30 - 18:00',
            'h_jueves' =>'10:00 - 14:00',
            'h_viernes'=>'',

        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Cerrillos',
            'rutero'=>'Daniel',
            'lunes'=>'1',
            'martes'=>'1',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'14:30 - 18:00',
            'h_martes'=>'10:00 - 14:00',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Lo Espejo',
            'rutero'=>'Daniel',
            'lunes'=>'1',
            'martes'=>'1',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'14:30 - 18:00',
            'h_martes'=>'10:00 - 14:00',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'14:30 - 18:00',
        ));

    }
}
