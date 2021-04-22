<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGendersTable extends Migration {

	public function up()
	{
		Schema::create('genders', function(Blueprint $table) {
			$table->id();
			$table->string('name', 191)->unique()->nullable();
			$table->string('name_ar', 191)->unique()->nullable();
			$table->boolean('active')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('genders');
	}
}
