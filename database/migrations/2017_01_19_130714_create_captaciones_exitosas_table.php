<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptacionesExitosasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('captaciones_exitosas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('n_dues');
			$table->string('id_fundacion');
			$table->string('fono_1');
			$table->string('fono_2');
			$table->string('fono_3');
			$table->string('fono_4');
			$table->string('nombre');
			$table->string('apellido');
			$table->string('correo_1');
			$table->string('correo_2');
			$table->string('firma_inscripcion');
			$table->string('otro_antecedente');
			$table->string('monto');
			$table->string('estado');
			$table->string('volver_allamar');
			$table->string('mensaje');
			$table->string('observacion');
			$table->string('n_llamados');
			$table->string('primer_llamado');
			$table->string('segundo_llamado');
			$table->string('tercer_llamado');
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
		Schema::drop('captaciones_exitosas');
	}

}
