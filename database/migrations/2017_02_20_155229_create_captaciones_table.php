<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptacionesTable extends Migration {

	/**
	 *en esta tabla se guarda la ifnormacion de las campañas en bruto.
	 * es decir, aca se guarda la informacion que nos envia la fundacion y es de esta tabla de donde se recogen
	 * lso legistros para la llamada de los teleoperadores
	 */
	public function up()
	{
		Schema::create('captaciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('campana')->nullable();
			$table->string('estado_registro')->nullable();
			$table->string('nom_fundacion')->nullable();
			$table->string('n_dues')->nullable();
			$table->string('id_fundacion')->nullable();
			$table->string('fono_1')->nullable();
			$table->string('fono_2')->nullable();
			$table->string('fono_3')->nullable();
			$table->string('fono_4')->nullable();
			$table->string('nombre')->nullable();
			$table->string('apellido')->nullable();
			$table->string('correo_1')->nullable();
			$table->string('correo_2')->nullable();
			$table->string('firma_inscripcion')->nullable();
			$table->string('otro_antecedente')->nullable();
			$table->string('monto')->nullable();
			$table->string('estado')->nullable();
			$table->string('volver_llamar')->nullable();
			$table->string('mensaje')->nullable();
			$table->string('observacion')->nullable();
			$table->string('n_llamados')->nullable();
			$table->string('primer_llamado')->nullable();
			$table->string('segundo_llamado')->nullable();
			$table->string('tercer_llamado')->nullable();
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
		Schema::drop('captaciones');
	}

}
