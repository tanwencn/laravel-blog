<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('links', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('term_id')->unsigned()->default(0)->index('term_id');
			$table->bigInteger('linkable_id')->unsigned()->nullable();
			$table->string('linkable_type', 191)->nullable();
			$table->bigInteger('parent_id')->unsigned()->default(0)->index('parent_id');
			$table->string('title', 80)->default('');
			$table->string('url', 191)->default('');
			$table->string('target', 30)->default('');
			$table->string('description', 191)->default('');
			$table->string('image', 191)->default('');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('links');
	}

}
