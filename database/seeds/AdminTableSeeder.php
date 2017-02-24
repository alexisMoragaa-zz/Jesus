<?php

use Illuminate\Database\Seeder;


class AdminTableSeeder extends Seeder
{


    public function run()
    {
        \DB::table('users')->insert(array(
            'name' =>'Alexis',
            'email' =>'alexis.moraga.gallardo@gmail.com',
            'perfil' => '1',
            'estado' => 'Activo',
            'password' =>\Hash::make('1111111')

        ));
    }
}