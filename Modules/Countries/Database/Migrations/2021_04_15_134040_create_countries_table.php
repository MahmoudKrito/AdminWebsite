<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration {

	public function up()
	{
		Schema::create('countries', function(Blueprint $table) {
            $table->id();
			$table->string('name', 191)->unique()->nullable();
			$table->string('name_ar', 191)->unique()->nullable();
			$table->string('image', 191)->nullable();
			$table->string('code', 5)->nullable();
			$table->string('phone_code', 191)->nullable();
			$table->bigInteger('currency_id')->nullable();
			$table->boolean('active')->default(1);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('countries');
	}
}
