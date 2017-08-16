<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComunaRetirosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comuna_retiros', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('region');
			$table->string('ciudad');
			$table->string('comuna');
			$table->string('rutero');
			$table->integer('lunes');
			$table->string('h_lunes');
			$table->integer('martes');
			$table->string('h_martes');
			$table->integer('miercoles');
			$table->string('h_miercoles');
			$table->integer('jueves');;
			$table->string('h_jueves');
			$table->integer('viernes');
			$table->string('h_viernes');
			$table->integer('sabado');
			$table->string('h_sabado');
			$table->integer('domingo');
			$table->integer('h_domingo');

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
		Schema::drop('comuna_retiros');
	}

}
