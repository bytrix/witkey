<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('User', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username')->unique();
			$table->string('password');
			$table->char('gender')->default('M');
			$table->string('email')->unique();
			$table->string('tel')->nullable();
			$table->string('school')->nullable();
			$table->string('dorm')->nullable();
			$table->string('ip');
			$table->integer('credit')->default(0);
			$table->boolean('active')->default(true);
			$table->string('remember_token');
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
		Schema::drop('user');
	}

}
