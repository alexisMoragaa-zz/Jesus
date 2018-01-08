<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLettersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('letters', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('number');
			$table->string('estado');
			$table->integer('mandatos');
			$table->string('creadaPor');
			$table->string('entregadaPor');
			$table->string('fecha_entrega');
			$table->string('observaciones');
			$table->integer('id_fundacion')->unsigned();
			$table->timestamps();


			$table->foreign('id_fundacion')->references('id')->on('fundacions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('letters');
	}

}
