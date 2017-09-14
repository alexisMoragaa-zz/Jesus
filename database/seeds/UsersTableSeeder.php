<?php

use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{

/**
 * seeder para agragar usuarios al sistema.
 * no se uso un faker ya que son pocos usuarios y con esto controlamos lso pribilegios de cada usuario para posteriores pruebas de privilegios
*/
    public function run()
    {
        // teleoperadores

        \DB::table('users')->insert(array(
            'name' => 'Fabian',
            'last_name'=>'Gonzalez',
            'email' => 'Fabian.gonzalez@gmail.com',
            'perfil' => '2',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana' => '1',
            'turno'  =>'AM',
            'fecha_ingreso'  =>  '07-01-2016',
            'fecha_termino'  =>  '00-00-0000'

        ));
        \DB::table('users')->insert(array(
            'name' => 'Julissa',
            'last_name'=>'Luna',
            'email' => 'Julissa@gmail.com',
            'perfil' => '2',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  =>  '2',
            'turno'  =>  'AM',
            'fecha_ingreso' => '12-03-2017',
            'fecha_termino'  =>  '00-00-0000'
            

        ));
        \DB::table('users')->insert(array(
            'name' => 'Jessarela',
            'last_name'=>'Montaner',
            'email' => 'Jessarela.Montaner@gmail.com',
            'perfil' => '2',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => '3',
            'turno'  =>  'AM',
            'fecha_ingreso'  =>  '02-03-2017',
            'fecha_termino'  =>  '00-00-0000'

        ));
        \DB::table('users')->insert(array(
            'name' => 'Macarena',
            'last_name'=>'Valenzuela',
            'email' => 'Macarena.Valenzuela@gmail.com',
            'perfil' => '2',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana' => '4',
            'turno'  =>  'AM',
            'fecha_ingreso'  =>  '01-02-2017',
            'fecha_termino'  =>  '00-00-0000'

        ));
        \DB::table('users')->insert(array(
            'name' => 'Patricio',
            'last_name'=>'Manaut',
            'email' => 'Patricio.Manaut@gmail.com',
            'perfil' => '2',
            'estado' => 'Desvimculado',
            'password' => \Hash::make('123456'),
            'campana'  => '5',
            'turno'  =>  'PM',
            'fecha_ingreso'  =>  '15-02-2017',
            'fecha_termino'  =>  '25-05-2017'
        ));

        //supervisor
        \DB::table('users')->insert(array(
            'name' => 'Maria Fernanda',
            'last_name'=>'Arroz',
            'email' => 'Maria.Fernanda@gmail.com',
            'perfil' => '3',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => '5',
            'turno'  =>  'PM',
            'fecha_ingreso'  =>  '10-02-2017',
            'fecha_termino'  =>  '22-04-2017'

        ));

        //ruteros
        \DB::table('users')->insert(array(
            'name' => 'Nicolas',
            'last_name'=>'Castillo',
            'email' => 'nico@gmail.com',
            'perfil' => '5',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => '5',
            'turno'  =>  'TD',
            'fecha_ingreso'  =>  '10-02-2017',
            'fecha_termino'  =>  '22-04-2017'
        ));

        \DB::table('users')->insert(array(
            'name' => 'Rodrigo',
            'last_name'=>'Maldonado',
            'email' => 'rodrigo@gmail.com',
            'perfil' => '5',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => '5',
            'turno'  =>  'TD',
            'fecha_ingreso'  =>  '10-02-2017',
            'fecha_termino'  =>  '22-04-2017'
        ));
        \DB::table('users')->insert(array(
            'name' => 'Teleoperador',
            'last_name'=>'Teo',
            'email' => 'teo@teo.com',
            'perfil' => '2',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => '5',
            'turno'  =>  'TD',
            'fecha_ingreso'  =>  '10-02-2017',
            'fecha_termino'  =>  '22-04-2017'
        ));
        \DB::table('users')->insert(array(
            'name' => 'Operaciones',
            'last_name'=>'ope',
            'email' => 'ope@ope.com',
            'perfil' => '4',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => '5',
            'turno'  =>  'TD',
            'fecha_ingreso'  =>  '10-02-2017',
            'fecha_termino'  =>  '22-04-2017'
        ));
        \DB::table('users')->insert(array(
            'name' => 'Supervisor',
            'last_name'=>'sup',
            'email' => 'sup@sup.com',
            'perfil' => '3',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => '5',
            'turno'  =>  'TD',
            'fecha_ingreso'  =>  '10-02-2017',
            'fecha_termino'  =>  '22-04-2017'
        ));
        \DB::table('users')->insert(array(
            'name' => 'Rutero',
            'last_name'=>'rut',
            'email' => 'rut@rut.com',
            'perfil' => '5',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => '5',
            'turno'  =>  'TD',
            'fecha_ingreso'  =>  '10-02-2017',
            'fecha_termino'  =>  '22-04-2017'
        ));
    }
}