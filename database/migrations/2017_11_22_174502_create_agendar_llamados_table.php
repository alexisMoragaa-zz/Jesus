<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendarLlamadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agendar_llamados', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_llamado')->unsigned();
			$table->integer('teleoperador')->unsigned();
			$table->string('fecha_llamado');
			$table->string('estado_llamado');
			$table->timestamps();

			$table->foreign('id_llamado')->references('id')->on('captaciones');
			$table->foreign('teleoperador')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agendar_llamados');
	}

}
