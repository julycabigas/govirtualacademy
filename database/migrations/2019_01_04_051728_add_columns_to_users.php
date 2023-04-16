<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname')->nullable()->after('email');
            $table->string('lastname')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('address_2')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('municipality')->nullable();
            $table->longtext('about')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('address_2')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('municipality')->nullable();
            $table->longtext('about')->nullable();
        });
    }
}
