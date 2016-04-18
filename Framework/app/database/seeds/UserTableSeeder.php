<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		User::create([
			'username'        => 'Campus Witkey',
			'avatar'          => '96d6f2e7e1f705ab5e59c84a6dc009b2',
			'password'        => '$2y$10$7y9LVEC9WPrs3KrV/BVA5.41Ktxc/LLqjrhKxP0UqO00FtaD2sf4e',	// admin1234
			'permission'      => '3',																// admin
			'tel'             => '13358212686',
			'email'           => 'admin@campuswitkey.com',
			'qq'              => '121782537',
			'school'          => 1,
			'dorm'            => 'no',
			'truename'        => '杰',
			'enrollment_date' => '2013-09-10',
			'major'           => 13,
			'authenticated'   => 2,
			'city'            => '福州',
			'random_name'     => false
		]);
		// User::create(['username'=>'Tom'      , 'email'=>'tom@github.com'  , 'password'=>'admin1234', 'authenticated'=>2]);
		// User::create(['username'=>'Marry'    , 'email'=>'marry@github.com' , 'password'=>'admin1234', 'authenticated'=>2]);
		// User::create(['username'=>'Bob'      , 'email'=>'bob@github.com'    , 'password'=>'admin1234', 'authenticated'=>2]);
		// User::create(['username'=>'Michael'  , 'email'=>'mike@github.com', 'password'=>'admin1234', 'authenticated'=>2]);
		// User::create(['username'=>'John'     , 'email'=>'john@github.com', 'password'=>'admin1234', 'authenticated'=>2]);
		// User::create(['username'=>'Linus'    , 'email'=>'linus@github.com', 'password'=>'admin1234', 'authenticated'=>2]);
		// User::create(['username'=>'Anonymous', 'email'=>'anonymous@github.com', 'password'=>'admin1234', 'authenticated'=>2]);
	}
}
