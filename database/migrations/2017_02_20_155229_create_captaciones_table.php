<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptacionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('captaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('n_interno_dues')->nullable();
			$table->string('id_interno_funda')->nullable();
			$table->string('origen')->nullable();
			$table->string('fono1')->nullable();
			$table->string('fono2')->nullable();
			$table->string('fono3')->nullable();
			$table->string('fono4')->nullable();
			$table->string('nombre')->nullable();
			$table->string('apellido')->nullable();
			$table->string('correo1')->nullable();
			$table->string('correo2')->nullable();
			$table->string('fecha_firma_inscripcion')->nullable();
			$table->string('otro_antecedente')->nullable();
			$table->string('monto_original')->default(0);
			$table->string('monto_aporte')->nullable();
			$table->string('monto_final')->nullable();
			$table->string('estado')->nullable();
			$table->string('fecha_volver_allamar')->nullable();
			$table->string('mensaje')->nullable();
			$table->string('observacion')->nullable();
			$table->string('n_llamados')->nullable();
			$table->string('fecha_primer_llamado')->nullable();
			$table->string('fecha_segundo_llamado')->nullable();
			$table->string('fecha_tercer_llamado')->nullable();
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
		Schema::drop('captaciones');
	}

}
