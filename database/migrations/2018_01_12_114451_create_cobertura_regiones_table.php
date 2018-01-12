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
			$table->string('sucursal');
			$table->string('region');
			$table->string('comuna');
			$table->string('cobertura');

			$table->string('semana_1_lunes');
			$table->string('semana_1_martes');
			$table->string('semana_1_miercoles');
			$table->string('semana_1_jueves');
			$table->string('semana_1_viernes');

			$table->string('semana_2_lunes');
			$table->string('semana_2_martes');
			$table->string('semana_2_miercoles');
			$table->string('semana_2_jueves');
			$table->string('semana_2_viernes');

			$table->string('semana_3_lunes');
			$table->string('semana_3_martes');
			$table->string('semana_3_miercoles');
			$table->string('semana_3_jueves');
			$table->string('semana_3_viernes');

			$table->string('semana_4_lunes');
			$table->string('semana_4_martes');
			$table->string('semana_4_miercoles');
			$table->string('semana_4_jueves');
			$table->string('semana_4_viernes');

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
