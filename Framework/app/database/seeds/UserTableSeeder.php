<?php

class UserTableSeeder extends Seeder {

	public function run()
	{
		User::create(['username'=>'Jack'   , 'email'=>'jack@gmail.com'  , 'password'=>'admin1234']);
		User::create(['username'=>'Tom'    , 'email'=>'tom@gitub.com'   , 'password'=>'admin1234']);
		User::create(['username'=>'Marry'  , 'email'=>'marry@yahoo.com' , 'password'=>'admin1234']);
		User::create(['username'=>'Bob'    , 'email'=>'bob@live.com'    , 'password'=>'admin1234']);
		User::create(['username'=>'Michael', 'email'=>'mike@twitter.com', 'password'=>'admin1234']);
	}

}
