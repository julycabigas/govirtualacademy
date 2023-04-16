<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableExerciseEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('content');
            $table->longText('comment')->nullable();
            $table->boolean('has_passed')->nullable();
            $table->integer('exercise_id')->unsigned()->nullable();
            $table->foreign('exercise_id')
                 ->references('id')->on('exercises')
                 ->onDelete('set null');
                 $table->integer('user_id')->unsigned()->nullable();
                 $table->foreign('user_id')
                      ->references('id')->on('users')
                      ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_entries');
    }
}
