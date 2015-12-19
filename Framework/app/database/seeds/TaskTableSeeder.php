<?php

class TaskTableSeeder extends Seeder {

	public function run()
	{
		// no
		Task::create([
			'user_id'=>1,
			'title'=>'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttest',
			'detail'=>'testtesttesttesttestttesttesttesttestttesttesttesttestttesttesttesttestttesttesttesttestttesttesttesttestttesttesttesttesttesttesttesttesttesttesttest',
			'amount'=>200,
			'expiration'=>date('Y-m-d', time())
		]);
		Task::create([
			'user_id'=>2,
			'title'=>'测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试',
			'detail'=>'测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试测试',
			'amount'=>200,
			'expiration'=>date('Y-m-d', time())
		]);
		Task::create([
			'user_id'=>3,
			'title'=>'测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test',
			'detail'=>'测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test测试test',
			'amount'=>200,
			'expiration'=>date('Y-m-d', time())
		]);
	}

}
