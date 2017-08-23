<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundacionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fundacions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('razon social');
			$table->string('rut');
			$table->string('agendamiento');
			$table->string('upgrade');
			$table->string('agendamiento');
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
		Schema::drop('fundacions');
	}

}
