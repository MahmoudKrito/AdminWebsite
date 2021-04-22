<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration {

	public function up()
	{
		Schema::create('areas', function(Blueprint $table) {
            $table->id();
			$table->string('name', 191)->nullable();
			$table->string('name_ar', 191)->nullable();
			$table->boolean('active')->default(1);
			$table->bigInteger('city_id');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('areas');
	}
}
