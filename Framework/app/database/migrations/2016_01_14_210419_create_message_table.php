<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Message', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('from_user_id');
			$table->integer('to_user_id');
			$table->text('message');
			$table->boolean('read');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Message');
	}

}
