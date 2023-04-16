<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgeRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badge_requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('badge_id')->unsigned();
            $table->foreign('badge_id')
                  ->references('id')->on('badges')
                  ->onDelete('cascade');  
            $table->integer('group_identifiers_id')->unsigned();
            $table->foreign('group_identifiers_id')
                ->references('id')->on('course_group_identifiers')
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
        Schema::dropIfExists('badge_requirements');
    }
}
