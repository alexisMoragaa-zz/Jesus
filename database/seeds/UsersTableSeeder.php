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
            'name' => 'Informes',
            'last_name'=>'Informaticos',
            'email' => 'informes@gmail.com',
            'perfil' => '6',
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
            'perfil' => '4',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  =>  '1',
            'turno'  =>  'AM',
            'fecha_ingreso' => '12-03-2017',
            'fecha_termino'  =>  '00-00-0000'


        ));


        //supervisor
        \DB::table('users')->insert(array(
            'name' => 'Maria Fernanda',
            'last_name'=>'Arroz',
            'email' => 'Maria.Fernanda@gmail.com',
            'perfil' => '3',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => '1',
            'turno'  =>  'PM',
            'fecha_ingreso'  =>  '10-02-2017',
            'fecha_termino'  =>  '22-04-2017'

        ));

      //Teleoperador
      \DB::table('users')->insert(array(
          'name' => 'Camila',
          'last_name'=>'Cabello',
          'email' => 'fiftharmony@gmail.com',
          'perfil' => '2',
          'estado' => 'Activo',
          'password' => \Hash::make('ot5'),
          'campana'  => '1',
          'turno'  =>  'PM',
          'fecha_ingreso'  =>  '10-02-2017',
          'fecha_termino'  =>  '22-04-2017'

      ));

      \DB::table('users')->insert(array(
          'name' => 'Catalina',
          'last_name'=>'Toro',
          'email' => 'cata@gmail.com',
          'perfil' => '2',
          'estado' => 'Activo',
          'password' => \Hash::make('cata'),
          'campana'  => '1',
          'turno'  =>  'PM',
          'fecha_ingreso'  =>  '10-02-2017',
          'fecha_termino'  =>  '22-04-2017'

      ));

        //ruteros
        \DB::table('users')->insert(array(
            'name' => 'Danko',
            'last_name'=>'valenzuela',
            'email' => 'danko@gmail.com',
            'perfil' => '5',
            'estado' => 'Activo',
            'password' => \Hash::make('123456'),
            'campana'  => '1',
            'turno'  =>  'PM',
            'fecha_ingreso'  =>  '10-02-2017',
            'fecha_termino'  =>  '22-04-2017'
          ));

          \DB::table('users')->insert(array(
              'name' => 'Eduardo',
              'last_name'=>'becerra',
              'email' => 'eduardo@gmail.com',
              'perfil' => '5',
              'estado' => 'Activo',
              'password' => \Hash::make('eduardobecerra'),
              'campana'  => '1',
              'turno'  =>  'PM',
              'fecha_ingreso'  =>  '10-02-2017',
              'fecha_termino'  =>  '22-04-2017'
            ));

            \DB::table('users')->insert(array(
                'name' => 'Por',
                'last_name'=>'Definir',
                'email' => 'definior@gmail.com',
                'perfil' => '5',
                'estado' => 'Activo',
                'password' => \Hash::make('123456'),
                'campana'  => '1',
                'turno'  =>  'PM',
                'fecha_ingreso'  =>  '10-02-2017',
                'fecha_termino'  =>  '22-04-2017'
              ));

    }
}
