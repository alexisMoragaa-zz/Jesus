<?php

use Illuminate\Database\Seeder;


class FundacionesTableSeeder extends Seeder
{


    public function run()
    {

      \DB::table('fundacions')->insert(array(
          'nombre' => 'Sin Fundacion',
          'razon_social' => 'Sin Fundacion',
          'rut' => '11111111',
          'fono' => '11111111',
          'email' => '@',
          'agendamiento' => '0',
          'upgrade' => '0',
          'regiones' => '0',
        ));

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
