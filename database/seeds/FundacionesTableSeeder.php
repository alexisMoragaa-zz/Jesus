<?php

use Illuminate\Database\Seeder;


class FundacionesTableSeeder extends Seeder
{


    public function run()
    {
        \DB::table('fundacions')->insert(array(
            'nombre' => 'Greenpeace',
            'razon_social' => 'Greenpeace org',
            'rut' => '123456789',

            'fono' => '12345678',
            'email' => 'Greenpeace@Greenpace.org',
            'agendamiento' => '1',
            'upgrade' => '1',
            'regiones' => '1',

        ));

        \DB::table('fundacions')->insert(array(
            'nombre' => 'Luz',
            'razon_social' => 'Luz org',
            'rut' => '987654321',
             'fono' => '12345678',
            'email' => 'fundacionLuz@luz.org',
            'agendamiento' => '1',
            'upgrade' => '1',
            'regiones' => '1',

        ));

        \DB::table('fundacions')->insert(array(
            'nombre' => 'Maria Ayuda',
            'razon_social' => 'Maria Ayuda.ltda',
            'rut' => '55555556',
            'fono' => '12345678',
            'email' => 'Maria@ayuda.cl',
            'agendamiento' => '1',
            'upgrade' => '1',
            'regiones' => '1',

        ));
    }
}