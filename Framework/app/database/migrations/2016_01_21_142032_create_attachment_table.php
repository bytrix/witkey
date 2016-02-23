<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Attachment', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('file_name');
			$table->string('file_hash');
			$table->string('file_ext');
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
		Schema::drop('Attachment');
	}

}
