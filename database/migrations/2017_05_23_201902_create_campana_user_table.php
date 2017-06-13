<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampanaUserTable extends Migration {

	/**
	 *en esta tabla se guarda la relacion muchos a muchso entre usuarios y campañas, ya que un usuario puede trabajar en 
	 * muchas campañas. como a su ves muchso usuarios pueden estar trabajando en la misma campaña
	 * es desde esta tabla donde se filtraran los registros que pueden ver lso usuarios dependiedo de la campaña asignada por el supervisor
	 */
	public function up()
	{
		//
		Schema::create('campana_user',function(Blueprint $table){

			$table->increments('id');

			$table->integer('campana_id')->unsigned();
			$table->integer('user_id')->unsigned();
            $table->date('fecha_inicio');
            $table->date('fecha_termino');
            $table->string('motivo_termino');
       		$table->timestamps();



			$table->foreign('campana_id')->references('id')->on('campanas')
				->onDelete('cascade');

			$table->foreign('user_id')->references('id')->on('users')
				->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('campana_user');
	}

}
