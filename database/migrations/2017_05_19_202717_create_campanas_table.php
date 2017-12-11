<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampanasTable extends Migration {

	/**
	 *en esta tabla se guarda informacion de las campañas. 
	 * esta tabla tendra relacion con la tabla captaciones ya que es en esta  tabla en donde se guardan lso numeros telefonicos para
	 * ser llamados y dichos numeros deben pertenecer a una campaña
	 */
	public function up()
	{
		Schema::create('campanas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre_campana');
			$table->string('ubicacion');
			$table->string('fundacion');
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
		Schema::drop('campanas');
	}

}
