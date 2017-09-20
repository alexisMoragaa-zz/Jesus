<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptacionesExitosasTable extends Migration {

	/**
*
	 * ejn la tabla de captaciones exitosas se guarda la informacion de los "clientes"
	 * una vez que aceptan la ser socios de la fundacion. es aca donde se registra datos como la direccion entre otros datos 
	 * necesarios para la creacion de rutas
	 */
	public function up()
	{
		Schema::create('captaciones_exitosas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('n_dues');
			$table->string('id_fundacion');
			$table->string('fecha_captacion');
			$table->string('fecha_agendamiento');
			$table->string('estado_captacion');
			$table->string('motivo_cap');
			$table->string('motivo_mdt');
			$table->string('estado_mandato');
			$table->string('tipo_retiro');
			$table->string('jornada');
			$table->string('horario');
			$table->string('nombre');
			$table->string('apellido');
			$table->string('rut');
			$table->string('direccion');
			$table->string('comuna');
			$table->string('ciudad');
			$table->string('region');
			$table->string('fono_1');
			$table->string('correo_1');
			$table->string('observaciones');
			$table->string('rutero');
			$table->string('teleoperador');
			$table->string('fundacion');
			$table->string('nom_campana');
			$table->string('monto');
			$table->string('forma_pago');
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('captaciones_exitosas');
	}

}
