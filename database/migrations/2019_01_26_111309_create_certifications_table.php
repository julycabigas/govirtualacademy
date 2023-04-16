<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            $table->integer('result_id')->unsigned()->nullable();
            $table->foreign('result_id')
                    ->references('id')->on('results')
                    ->onDelete('set null');
            $table->integer('course_id')->unsigned()->nullable();        
            $table->foreign('course_id')
                    ->references('id')->on('courses')
                    ->onDelete('set null');        
            $table->boolean('emailed');        
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
        Schema::dropIfExists('certifications');
    }
}
