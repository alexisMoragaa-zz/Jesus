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
        $this->call('CampanaUserTableSeeder');
        /*DB::table('users')->insert([
            'name' => 'eddy',
            'email' => 'adan.e.c.p@hotmail.com',
			'perfil' => '1',
            'password' => bcrypt('123456'),
        ]);
        */
    }

}
