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
			$table->string('task_title');
			$table->text('task_detail');
			$table->integer('bidder_id');
			$table->decimal('reward');
			$table->boolean('overdue');
			$table->integer('expire');
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
		Schema::drop('task');
	}

}
