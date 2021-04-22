<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration {

	public function up()
	{
		Schema::create('currencies', function(Blueprint $table) {
			$table->id();
			$table->string('name', 191)->nullable();
			$table->string('name_ar', 191)->nullable();
			$table->string('symbol', 191)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('currencies');
	}
}
