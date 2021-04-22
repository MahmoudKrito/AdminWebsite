<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration {

	public function up()
	{
		Schema::create('cities', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 191)->nullable();
			$table->string('name_ar', 191)->nullable();
			$table->boolean('active')->default(1);
			$table->bigInteger('country_id');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('cities');
	}
}
