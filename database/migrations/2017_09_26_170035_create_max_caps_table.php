<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaxCapsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('max_caps', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('maxDay');
			$table->integer('maxAm');
			$table->integer('maxPm');
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
		Schema::drop('max_caps');
	}

}
