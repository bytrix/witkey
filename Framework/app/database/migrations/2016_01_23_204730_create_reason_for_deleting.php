<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReasonForDeleting extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ReasonForDeleting', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->text('reason');
			$table->integer('task_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ReasonForDeleting');
	}

}
