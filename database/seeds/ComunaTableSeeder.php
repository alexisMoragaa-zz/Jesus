<?php

use Illuminate\Database\Seeder;


class ComunaTableSeeder extends Seeder
{
    
    public function run()
    {
        \DB::table('comuna_retiros')->insert(array(

        'region'=>'metropolitana',
        'ciudad'=>'santiago',
        'comuna'=>'Lo Barnechea',
            'lunes'=>'1',
            'rutero'=>'Rutero',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'10:00 - 13:30',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'14:30 - 17:00',
    ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Vitacura',
            'rutero'=>'Rutero',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'10:00 - 13:30',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'14:30 - 17:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Huechuraba',
            'rutero'=>'Rutero',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'10:00 - 13:30',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'14:30 - 17:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Las Condes',
            'rutero'=>'Rutero',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'10:00 - 13:30',
            'h_miercoles'=>' 14:30 - 17:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Providencia',
            'rutero'=>'Nicolas',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'10:00 - 13:30',
            'h_miercoles'=>' 14:30 - 17:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'La Reina',   'rutero'=>'Nicolas',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'10:00 - 13:30',
            'h_miercoles'=>' 14:30 - 17:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Peñalolen',
            'rutero'=>'Nicolas',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'14:30 - 17:00',
            'h_martes'=>'',
            'h_miercoles'=>'10:00 - 13:30',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Ñuñoa',
            'rutero'=>'Nicolas',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'14:30 - 17:00',
            'h_martes'=>'',
            'h_miercoles'=>'10:00 - 13:30',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Macul',
            'rutero'=>'Nicolas',
            'lunes'=>'1',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'14:30 - 17:00',
            'h_martes'=>'',
            'h_miercoles'=>'10:00 - 13:30',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'La Florida',
            'rutero'=>'Nicolas',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'0',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 17:00',
            'h_miercoles'=>'',
            'h_jueves' =>'14:30 - 17:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Puente Alto',
            'rutero'=>'Nicolas',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'0',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 17:00',
            'h_miercoles'=>'',
            'h_jueves' =>'14:30 - 17:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'El Bosque',
            'rutero'=>'Nicolas',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'0',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 17:00',
            'h_miercoles'=>'',
            'h_jueves' =>'14:30 - 17:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'La Pintana',
            'rutero'=>'Nicolas',
            'lunes'=>'0',
            'martes'=>'1',
            'miercoles'=>'0',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'14:30 - 17:00',
            'h_miercoles'=>'',
            'h_jueves' =>'14:30 - 17:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'San Joaquin',
            'rutero'=>'Nicolas',
            'lunes'=>'0',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'10:00 - 13:30',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'La Granja',
            'rutero'=>'Nicolas',
            'lunes'=>'0',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'10:00 - 13:30',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'San Ramon',
            'rutero'=>'Nicolas',
            'lunes'=>'0',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'10:00 - 13:30',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Santoago Centro',
            'rutero'=>'Rodrigo',
            'lunes'=>'1',
            'martes'=>'1',
            'miercoles'=>'1',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'10:00 - 13:30',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'10:00 - 13:30',
            'h_jueves' =>'14:30 - 18:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Estacion Central',
            'rutero'=>'Rodrigo',
            'lunes'=>'1',
            'martes'=>'1',
            'miercoles'=>'0',
            'jueves'=>'',
            'viernes'=>'0',
            'h_lunes'=>'10:00 - 14:30',
            'h_martes'=>'14:30 - 18:00',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'',

        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Independencia',
            'lunes'=>'1',
            'rutero'=>'rodrigo',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'10:00 - 13:30',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'10:00 - 13:30',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Recoleta',
            'lunes'=>'1',
            'rutero'=>'Rodrigo',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'14:30 - 18:00',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'10:00 - 13:30',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Conchali',
            'lunes'=>'1',
            'rutero'=>'Rodrigo',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'14:30 - 18:00',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'10:00 - 13:30',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Quilicura',
            'lunes'=>'1',
            'rutero'=>'Rodrigo',
            'martes'=>'0',
            'miercoles'=>'0',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'14:30 - 18:00',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'10:00 - 13:30',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Renca',
            'lunes'=>'0',
            'rutero'=>'Rodrigo',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'14:30 - 18:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Quinta Normal',
        'lunes'=>'0',
            'rutero'=>'Rodrigo',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'10:00 - 13:30',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Lo Prado',
            'lunes'=>'0',
            'rutero'=>'Rodrigo',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'10:00 - 13:30',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Pudahuel',
            'lunes'=>'0',
            'rutero'=>'Rodrigo',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'14:30 - 18:00',
            'h_jueves' =>'',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Cerro Navia',
            'lunes'=>'0',
            'rutero'=>'Rodrigo',
            'martes'=>'0',
            'miercoles'=>'1',
            'jueves'=>'0',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'14:30 - 18:00',
            'h_jueves' =>'',
            'h_viernes'=>'',

        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'La Cisterna',
            'lunes'=>'0',
            'rutero'=>'Rodrigo',
            'martes'=>'1',
            'miercoles'=>'',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'10:00 - 13:30',
            'h_miercoles'=>'',
            'h_jueves' =>'14:30 - 18:00',
            'h_viernes'=>'',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'San Miguel',
            'lunes'=>'0',
            'rutero'=>'Rodrigo',
            'martes'=>'1',
            'miercoles'=>'',
            'jueves'=>'1',
            'viernes'=>'0',
            'h_lunes'=>'',
            'h_martes'=>'10:00 - 13:30',
            'h_miercoles'=>'',
            'h_jueves' =>'14:30 - 18:00',
            'h_viernes'=>'',
        ));


        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Pedro Aguirre Cerda',
            'lunes'=>'0',
            'rutero'=>'Rodrigo',
            'martes'=>'1',
            'miercoles'=>'',
            'jueves'=>'0',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'10:00 - 13:30',
            'h_miercoles'=>'',
            'h_jueves' =>'',
            'h_viernes'=>'14:30 - 18:00',
        ));


        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Maipu',
            'lunes'=>'0',
            'rutero'=>'Rodrigo',
            'martes'=>'0',
            'miercoles'=>'',
            'jueves'=>'1',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'10:00 - 13:30',
            'h_viernes'=>'14:30 - 18:00',

        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Cerrillos',
            'lunes'=>'0',
            'rutero'=>'Rodrigo',
            'martes'=>'0',
            'miercoles'=>'',
            'jueves'=>'1',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'10:00 - 13:30',
            'h_viernes'=>'14:30 - 18:00',
        ));

        \DB::table('comuna_retiros')->insert(array(

            'region'=>'metropolitana',
            'ciudad'=>'santiago',
            'comuna'=>'Lo Espejo',
            'lunes'=>'0',
            'rutero'=>'Rodrigo',
            'martes'=>'0',
            'miercoles'=>'',
            'jueves'=>'1',
            'viernes'=>'1',
            'h_lunes'=>'',
            'h_martes'=>'',
            'h_miercoles'=>'',
            'h_jueves' =>'10:00 - 13:30',
            'h_viernes'=>'14:30 - 18:00',
        ));


    }
}