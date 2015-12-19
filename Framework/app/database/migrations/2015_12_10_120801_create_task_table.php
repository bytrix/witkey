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
			$table->integer('winning_bidder_id');
			$table->decimal('amount');
			$table->tinyInteger('type');

			/**
			 * Indicate a state of current task
			 *	0 for CLOSED
			 *	1 for PUBLISHED
			 *	2 for 
			 *	1
			 *	1
			 *	1
			 *	1
			 */
			$table->tinyInteger('state');
			$table->datetime('expiration');
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
