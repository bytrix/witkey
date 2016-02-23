<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotePivot extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Relationship between Task and Bidder
		Schema::create('QuotePivot', function(Blueprint $table)
		{
			$table->increments('id');
			// $table->string('uuid');
			$table->timestamps();
			$table->integer('task_id');
			$table->integer('user_id');
			$table->decimal('price');
			$table->text('summary');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('QuotePivot');
	}

}
