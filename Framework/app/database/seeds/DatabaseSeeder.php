<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		// $this->call('TaskTableSeeder');
		$this->call('AcademyTableSeeder');
		$this->call('MajorTableSeeder');
		$this->call('CategoryTableSeeder');
	}

}
