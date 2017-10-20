<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoRutasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estado_rutas', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('id_agendamiento')->unsigned();
			$table->string('primer_agendamiento');
			$table->string('estado_primer_agendamiento');
			$table->string('detalle_primer_agendamiento');
			$table->string('observacion_primer_agendamiento');
			$table->string('segundo_agendamiento');
			$table->string('estado_segundo_agendamiento');
			$table->string('detalle_segundo_agendamiento');
			$table->string('observacion_segundo_agendamiento');
			$table->string('tercer_agendamiento');
			$table->string('estado_tercer_agendamiento');
			$table->string('detalle_tercer_agendamiento');
			$table->string('observacion_tercer_agendamiento');
			$table->timestamps();
			$table->foreign('id')->references('id')->on('captaciones_exitosas')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('estado_rutas');
	}

}
