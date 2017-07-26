<?php

use Illuminate\Database\Seeder;


class AdminTableSeeder extends Seeder
{

/*seeder paera agragar un usuario de tipo administrador*/
    public function run()
    {
        \DB::table('users')->insert(array(
            'name' =>'Alexis',
            'last_name'=>'moraga',
            'rut'=>'18202912',
            'dv'=>'2',
            'email' =>'alexis.moraga.gallardo@gmail.com',
            'perfil' => '1',
            'estado' => 'Activo',
            'password' =>\Hash::make('1111111'),
            'turno'  =>  'TD',
            'fecha_nacimiento'=>'1993/07/01',
            'direccion'=>'galos #1550',
            'telefono'=>'977781885',
            'afp'=>'modelo',
            'previcion'=>'insapre',
            'nombre_isapre'=>'consalud',
            'tipo_cuenta'=>'Banco Estado Cuenta Rut',
            'n_cuenta'=>'18202912',
            'campana'=>'1',
            'fecha_ingreso'  =>  '01-11-2016 15:50',

        ));
    }
}