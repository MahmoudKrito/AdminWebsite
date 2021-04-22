<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonesTable extends Migration {

	public function up()
	{
		Schema::create('zones', function(Blueprint $table) {
			$table->id();
			$table->string('name', 191)->nullable();
			$table->string('name_ar', 191)->nullable();
			$table->bigInteger('area_id');
			$table->boolean('active')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('zones');
	}
}
