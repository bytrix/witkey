<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Task', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('title');
			$table->text('detail');
			$table->integer('winning_commit_id');
			$table->integer('winning_quote_id');
			$table->decimal('amount');
			$table->tinyInteger('type');

			/**
			 * Indicate a state of current task
			 *	0 for CLOSED
			 *	1 for PUBLISHED & ENROLLMENT
			 *	2 for PERFORMING
			 *	3 for CHECK
			 *	4 for FINISH
			 *	5 for EXPIRED
			 */
			$table->tinyInteger('state');
			$table->datetime('expiration');
			$table->string('place');
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
		Schema::drop('Task');
	}

}
