<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformeRutasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('informe_rutas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_ruta')->unsigned();
			$table->integer('id_captacion')->unsigned();
			$table->integer('rutero_id')->unsigned();
			$table->string('estado');
			$table->string('motivo');
			$table->string('fecha_agendamiento');
			$table->string('num_retiro');
			$table->string('rutero');
			$table->string('horario');
			$table->string('comuna');
			$table->string('imagen');
			$table->string('mandato');

			$table->foreign('id_ruta')->references('id')->on('estado_rutas');
			$table->foreign('id_captacion')->references('id')->on('captaciones_exitosas');
			$table->foreign('rutero_id')->references('id')->on('users');

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
		Schema::drop('informe_rutas');
	}

}
