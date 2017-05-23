<?php

use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{


    public function run()
    {
        // teleoperadores

        \DB::table('users')->insert(array(
            'name' => 'Fabian Gonzales',
            'email' => 'Fabian.gonzalez@gmail.com',
            'perfil' => '2',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana' => '1'

        ));
        \DB::table('users')->insert(array(
            'name' => 'Julissa Luna',
            'email' => 'Julissa@gmail.com',
            'perfil' => '2',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  =>  '2'
            

        ));
        \DB::table('users')->insert(array(
            'name' => 'Jessarela Montaner',
            'email' => 'Jessarela.Montaner@gmail.com',
            'perfil' => '2',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => '3'

        ));
        \DB::table('users')->insert(array(
            'name' => 'Macarena Valenzuela',
            'email' => 'Macarena.Valenzuela@gmail.com',
            'perfil' => '2',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana' => 'sin campana'

        ));
        \DB::table('users')->insert(array(
            'name' => 'Patricio Manaut',
            'email' => 'Patricio.Manaut@gmail.com',
            'perfil' => '2',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => 'sin campana'

        ));

        //supervisor
        \DB::table('users')->insert(array(
            'name' => 'Maria Fernanda',
            'email' => 'Maria.Fernanda@gmail.com',
            'perfil' => '3',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => 'sin campana'

        ));
    }
}