<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoberturaRegionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cobertura_regiones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sucursal')->nullable();
			$table->string('region')->nullable();
			$table->string('comuna')->nullable();
			$table->string('cobertura')->nullable();

			$table->string('semana_1_lunes')->nullable();
			$table->string('semana_1_martes')->nullable();
			$table->string('semana_1_miercoles')->nullable();
			$table->string('semana_1_jueves')->nullable();
			$table->string('semana_1_viernes')->nullable();

			$table->string('semana_2_lunes')->nullable();
			$table->string('semana_2_martes')->nullable();
			$table->string('semana_2_miercoles')->nullable();
			$table->string('semana_2_jueves')->nullable();
			$table->string('semana_2_viernes')->nullable();

			$table->string('semana_3_lunes')->nullable();
			$table->string('semana_3_martes')->nullable();
			$table->string('semana_3_miercoles')->nullable();
			$table->string('semana_3_jueves')->nullable();
			$table->string('semana_3_viernes')->nullable();

			$table->string('semana_4_lunes')->nullable();
			$table->string('semana_4_martes')->nullable();
			$table->string('semana_4_miercoles')->nullable();
			$table->string('semana_4_jueves')->nullable();
			$table->string('semana_4_viernes')->nullable();

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
		Schema::drop('cobertura_regiones');
	}

}
