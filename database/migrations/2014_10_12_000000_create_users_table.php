<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 	 *creacion de la tabla usuarios
	 	 *en esta tabla solo se guarda informacion de los usuarios que tendran acceso al webside ya sea total o parcial 
	 */
	
	/**
	 * el metodo up se utiliza para crear la tabla cuando se ejecuta la migracion desde la consola
	*/
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('perfil');
			$table->string('estado');
			$table->string('password', 60);
			$table->string('campana')->default('1');
			$table->string('turno');
			$table->string('fecha_ingreso');
			$table->string('fecha_termino');
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 *el metodo down por el contrario elimina la migracion cuando se ejecutan comandos como migrate:refresh o migrate:reset
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
