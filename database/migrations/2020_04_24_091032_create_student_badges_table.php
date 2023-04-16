<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_badges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('badge_id')->unsigned();
            $table->foreign('badge_id')
                ->references('id')->on('badges')
                ->onDelete('cascade'); 
            $table->integer('total_star');  
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
        Schema::dropIfExists('student_badges');
    }
}
