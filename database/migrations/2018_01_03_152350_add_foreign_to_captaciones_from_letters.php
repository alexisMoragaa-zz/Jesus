<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToCaptacionesFromLetters extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('captaciones_exitosas', function(Blueprint $table)
		{
			$table->integer('letter')->unsigned();
			$table->foreign('letter')->references('id')->on('letters');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('captaciones_exitosas', function(Blueprint $table)
		{
			$table->dropForeign('captaciones_exitosas_letter_foreign');
			$table->dropColumn('letter');

		});
	}

}
