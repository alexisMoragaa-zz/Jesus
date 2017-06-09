<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampanaUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
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
