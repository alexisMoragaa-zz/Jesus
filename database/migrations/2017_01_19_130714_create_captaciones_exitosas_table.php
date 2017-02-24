<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptacionesExitosasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('captaciones_exitosas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('n_interno_dues');
			$table->string('id_interno_funda');
			$table->string('origen');
			$table->string('fono1');
			$table->string('fono2');
			$table->string('fono3');
			$table->string('fono4');
			$table->string('nombre');
			$table->string('apellido');
			$table->string('correo1');
			$table->string('correo2');
			$table->string('fecha_firma_inscripcion');
			$table->string('otro_antecedente');
			$table->string('monto_original');
			$table->string('monto_aporte');
			$table->string('monto_final');
			$table->string('estado');
			$table->string('fecha_volver_allamar');
			$table->string('mensaje');
			$table->string('observacion');
			$table->string('n_llamados');
			$table->string('fecha_primer_llamado');
			$table->string('fecha_segundo_llamado');
			$table->string('fecha_tercer_llamado');
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
