<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrainings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('access_id')->unsigned();
            $table->foreign('access_id')
                    ->references('id')->on('access_levels')
                    ->onDelete('cascade');
           $table->integer('course_id')->unsigned();        
           $table->foreign('course_id')
                    ->references('id')->on('courses')
                    ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainings');
    }
}
