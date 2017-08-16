<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 *archivo que controla los sedeers
     * con este archivo seleccionamos que seeder se ejecutaran y en que orden se ejecutaran los seeders
	 */
	public function run()
    {

        $this->call('AdminTableSeeder');//lamada al seeder
        $this->call('CampanaTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('EstadosTableSeeder');
        $this->call('ComunaTableSeeder');
        //$this->call('CampanaUserTableSeeder');

    }

}
