<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->id();
			$table->string('name', 191)->unique()->nullable();
			$table->string('name_ar', 191)->unique()->nullable();
			$table->string('image', 191)->nullable();
			$table->bigInteger('gender_id')->nullable();
			$table->bigInteger('layout_id')->nullable();
			$table->bigInteger('parent_id')->default(0);
			$table->boolean('active')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('categories');
	}
}
