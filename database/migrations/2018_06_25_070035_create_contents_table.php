<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contents', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('slug', 200)->default('')->index('slug');
			$table->string('title', 120)->default('');
			$table->string('excerpt', 255)->default('');
			$table->string('taxonomy', 32)->default('');
			$table->boolean('is_release')->default(0);
			$table->smallInteger('order')->unsigned()->default(99);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contents');
	}

}
