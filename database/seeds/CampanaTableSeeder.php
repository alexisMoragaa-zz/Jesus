<?php

use Illuminate\Database\Seeder;


class CampanaTableSeeder extends Seeder
{


    public function run()
    {
        \DB::table('captaciones')->insert(array(
            'id'=> '1',
            'campana' => 'STA OR',
            'estado_registro' => '0',
            'nom_fundacion' => 'greenpeace',
            'fono_1'=>'77781885',
            'fono_2'=>'71979643',
            'fono_3'=>'9999999',
            'fono_4'=>'88888888',
            'nombre'=>'alexis antonio',
            'apellido'=>'moraga galardo',
            'correo_1'=>'alexis.moraga.galardo@gmail.com',
            'correo_2'=>'sin coreo',
            'firma_inscripcion'=>'2017-04-03',
            'otro_antecedente'=>'apoya el sur de chile',
            'monto'=>'30000',
            'estado'=>'agendado',
            'volver_llamar'=>'null',
            'mensaje'=>'todo ok',
            'observacion'=>'persona indica que la llame cuando esten a dos cuadras',
            'n_llamados'=>'2',
            'primer_llamado'=>'02-02-2017',
            'segundo_llamado'=>'03-03-2017',
            'tercer_llamado'=>'null'
          ));
    }
}