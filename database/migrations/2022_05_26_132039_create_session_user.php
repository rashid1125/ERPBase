<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_user', function (Blueprint $table) {
            $table->integer('sessionid')->autoIncrement();
            $table->string('session_id')->nullable();
            $table->string('uid')->nullable();
            $table->string('uname')->nullable();
            $table->string('countryname')->nullable();
            $table->string('cityname')->nullable();
            $table->string('region')->nullable();
            $table->string('userip')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->dateTime('logintime')->nullable();
            $table->dateTime('logouttime')->nullable();
            $table->dateTime('vrdate')->nullable();
            $table->integer('company_id')->nullable();
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
        Schema::dropIfExists('session_user');
    }
}
