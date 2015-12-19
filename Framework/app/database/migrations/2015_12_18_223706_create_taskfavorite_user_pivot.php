<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskfavoriteUserPivot extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Relationship between TaskFavorite and User
		Schema::create('TaskFavorite_User', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('task_favorite_id');
			$table->integer('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('TaskFavorite_User');
	}

}
