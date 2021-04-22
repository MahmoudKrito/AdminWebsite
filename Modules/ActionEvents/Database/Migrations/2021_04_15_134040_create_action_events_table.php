<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionEventsTable extends Migration {

	public function up()
	{
		Schema::create('action_events', function(Blueprint $table) {
            $table->id();
			$table->bigInteger('userable_id')->nullable();
			$table->string('userable_type', 191)->nullable();
			$table->bigInteger('actionable_id')->nullable();
			$table->string('actionable_type', 191)->nullable();
			$table->string('action', 191)->nullable();
			$table->text('comment')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('action_events');
	}
}
