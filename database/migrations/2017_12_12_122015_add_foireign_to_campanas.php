<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFoireignToCampanas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('campanas', function(Blueprint $table)
		{
			$table->integer('fundacion')->unsigned();
			$table->foreign('fundacion')->references('id')->on('fundacions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('campanas', function(Blueprint $table)
		{
			$table->dropForeign('campanas_fundacion_foreign');
			$table->dropColumn('fundacion');

		});
	}

}
