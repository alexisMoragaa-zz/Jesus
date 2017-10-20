<?php

use Illuminate\Database\Seeder;


class EstadosTableSeeder extends Seeder
{


    public function run()
    {
        \DB::table('estados')->insert(array(
            'estado'=>'Acepta Agendamiento',
            'modulo' =>'agendamiento',
            'tipo' => 'cu+'
        ));
        \DB::table('estados')->insert(array(
            'estado'=>'Acepta Grabacion',
            'modulo' =>'agendamiento',
            'tipo' => 'cu+'
        ));
        \DB::table('estados')->insert(array(
            'estado'=>'Acepta Delivery',
            'modulo' =>'agendamiento',
            'tipo' => 'cu+'
        ));
        \DB::table('estados')->insert(array(
            'estado'=>'Acepta Upgrade',
            'modulo' =>'agendamiento',
            'tipo' => 'cu+'
        ));
        \DB::table('estados')->insert(array(
            'estado'=>'Acepta Chilexpress',
            'modulo' =>'agendamiento',
            'tipo' => 'cu+'
        ));
        \DB::table('estados')->insert(array(
            'estado'=>'Acepta ir a Dues',
            'modulo' =>'agendamiento',
            'tipo' => 'cu+'
        ));
    //-------estados de agendamiento-----

        \DB::table('estados')->insert(array(
            'estado'=>'Civer Activista',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        \DB::table('estados')->insert(array(
            'estado'=>'Aporta a otra Fundacion',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Es Socio',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Fue Contactado',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Jubilado',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Menor de Edad',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'No tiene Cuenta',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Sin Dinero',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Sin Trabajo',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'No Interesado',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Molesto por Llamado',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Persona Cuelga',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Persona Cuelga',
            'modulo' =>'llamado',
            'tipo' => ''
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Quiere Renunciar',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Auto Upgrade',
            'modulo' =>'llamado',
            'tipo' => 'cu-'
        ));

//cu-

        DB::table('estados')->insert(array(
            'estado'=>'Fono Ocupado',
            'modulo' =>'llamado',
            'tipo' => 'cnu'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Grabadora',
            'modulo' =>'llamado',
            'tipo' => 'cnu'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Fax',
            'modulo' =>'llamado',
            'tipo' => 'fax'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'No Contesta',
            'modulo' =>'llamado',
            'tipo' => 'cnu'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Fuera de Servicio',
            'modulo' =>'llamado',
            'tipo' => 'cnu'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Mala Conexion',
            'modulo' =>'llamado',
            'tipo' => 'cnu'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Otra Persona',
            'modulo' =>'llamado',
            'tipo' => 'cnu'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Fallecido',
            'modulo' =>'llamado',
            'tipo' => 'cnu'
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Volver a llamar',
            'modulo' =>'llamado',
            'tipo' => 'cnu'
        ));

    //----------estados de llamadas---------

        DB::table('estados')->insert(array(
            'estado'=>'Cuenta Corriente',
            'modulo' =>'Pago',
            'tipo' => ''
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Cuenta Vista',
            'modulo' =>'Pago',
            'tipo' => ''
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Cuenta Rut',
            'modulo' =>'Pago',
            'tipo' => ''
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Tarjeta de Credito',
            'modulo' =>'Pago',
            'tipo' => ''
        ));
        DB::table('estados')->insert(array(
            'estado'=>'Movistar',
            'modulo' =>'Pago',
            'tipo' => ''
        ));

    //----------formas de pago--------------

        DB::table('estados')->insert(array(
            'estado'=>'No se encuentra en domicilio',
            'modulo' =>'Ruta',
            'tipo' => ''
        ));


        DB::table('estados')->insert(array(
            'estado'=>'Direccion erronea',
            'modulo' =>'Ruta',
            'tipo' => ''
        ));

        DB::table('estados')->insert(array(
            'estado'=>'Desiste',
            'modulo' =>'Ruta',
            'tipo' => ''
        ));

        DB::table('estados')->insert(array(
            'estado'=>'Pide Reagendar visita',
            'modulo' =>'Ruta',
            'tipo' => ''
        ));

        DB::table('estados')->insert(array(
            'estado'=>'Rutero no alcanza a llegar',
            'modulo' =>'Ruta',
            'tipo' => ''
        ));







    //-----------estados de ruta-----------


    }
/** estados de agendamiento
 *          Son los estados que el to utilizara para agendar o realizar captaciones
 **estados de llamado
 *          Son los estados que el to utilizara para definir el resultado de cada llamado
 * *Formas de pago
 *          Son las formas de pago validas para los agendamientos o captaciones del to
 * *Estados de ruta
 *          Son los estados con los cuales los ruteros identificaran el estado final de sus rutas.
 *
 */
}