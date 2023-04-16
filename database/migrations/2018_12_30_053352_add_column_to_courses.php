<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            
             $table->string('orig_price');
             $table->string('discount_price');
             $table->text('inclusions');
             $table->longtext('learn');
             $table->text('requirement');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {

             $table->string('orig_price');
             $table->string('discount_price');
             $table->text('inclusions');
             $table->longtext('learn');
             $table->text('requirement');
        });
    }
}
