<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Comment', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('from_whom_id');
			$table->integer('user_id');
			$table->integer('star');
			$table->text('content');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Comment');
	}

}
