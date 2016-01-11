<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommitPivot extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('CommitPivot', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('uuid');
			$table->timestamps();
			$table->integer('task_id');
			$table->integer('user_id');
			$table->text('summary');
			$table->integer('type');
			$table->integer('quote_id')->nullable();
			$table->string('file_hash');
			$table->datetime('pay_at');
			$table->boolean('win')->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('CommitPivot');
	}

}
