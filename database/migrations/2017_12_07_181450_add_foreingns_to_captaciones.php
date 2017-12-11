<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeingnsToCaptaciones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('captaciones', function(Blueprint $table)
		{
				$table->integer('fundacion')->unsigned();
				$table->integer('campana_id')->unsigned();
				$table->foreign('fundacion')->references('id')->on('fundacions');
				$table->foreign('campana_id')->references('id')->on('campanas');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('captaciones', function(Blueprint $table)
		{
			$table->dropForeign('captaciones_fundacion_foreign');
			$table->dropForeign('captaciones_campana_id_foreign');
			$table->dropColumn('fundacion');
			$table->dropColumn('campana_id');
		});

	}

}
