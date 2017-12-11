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
			$table->string('campana');
			$table->string('estado_registro');
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
			$table->string('estado')->default(0);
			$table->string('volver_llamar');
			$table->string('observacion');
			$table->string('estado_llamada1');
			$table->string('primer_llamado');
			$table->string('estado_llamada2');
			$table->string('segundo_llamado');
			$table->string('estado_llamada3');
			$table->string('tercer_llamado');
			$table->string('n_llamados');
			$table->string('f_ultimo_llamado');


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
