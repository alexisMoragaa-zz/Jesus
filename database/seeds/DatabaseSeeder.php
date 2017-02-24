<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
    {
        DB::table('users')->insert([
            'name' => 'eddy',
            'email' => 'adan.e.c.p@hotmail.com',
			'perfil' => '1',
            'password' => bcrypt('123456'),
        ]);
    }

}
