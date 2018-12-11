<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_goals', function (Blueprint $table) {
			$table->integer('class_id')->unsigned();
			$table->integer('goal_id')->unsigned();
			$table->integer('type_id')->default(1);
			$table->primary(['class_id','goal_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_goals');
    }
}
