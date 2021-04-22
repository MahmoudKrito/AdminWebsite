<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutsTable extends Migration {

	public function up()
	{
		Schema::create('layouts', function(Blueprint $table) {
			$table->id();
			$table->string('name', 191)->unique();
			$table->boolean('active')->default(1);
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('layouts');
	}
}
