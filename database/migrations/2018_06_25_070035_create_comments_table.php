<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('parent_id')->unsigned()->default(0)->index('parent_id');
			$table->bigInteger('user_id')->unsigned()->default(0)->index('user_id');
			$table->bigInteger('commentable_id')->unsigned()->index('content_id');
			$table->string('commentable_type');
			$table->text('content', 65535)->nullable();
			$table->text('reply_history')->nullable();
			$table->boolean('is_release')->default(0);
			$table->string('ip_address', 25)->default('');
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
		Schema::drop('comments');
	}

}
