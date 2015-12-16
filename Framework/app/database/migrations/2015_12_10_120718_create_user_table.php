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
			$table->integer('credit')->default(2000);
			$table->decimal('balance')->default(10);
			$table->boolean('active')->default(true);
			$table->string('remember_token');
			$table->string('real_name')->nullable();
			// $table->string('identity_card')->nullable();		// The image URL of a user's identity card (FOR STUDENT!)
			$table->date('enrollment_date')->nullable();		// The date when the user enroll school
			$table->string('major_category')->nullable();
			$table->string('major')->nullable();				// The profession which the user majored
			$table->string('specialty_tag')->nullable();		// The specialties or interests the user has

			/*
				To check whether the user passes through Real-name authentication.
					0 for Non-authenticated
					1 for To-be-authenticated
					2 for Authenticated
					3 for Authentication Failure
			*/
			$table->tinyInteger('authenticated')->default(0);
			$table->string('city')->nullable();
			$table->string('fingerprint')->nullable();
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
		Schema::drop('User');
	}

}
