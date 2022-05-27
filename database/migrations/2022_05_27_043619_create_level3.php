<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevel3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level3', function (Blueprint $table) {
            $table->integer('l3')->autoIncrement();
            $table->string('name');
            $table->string('l3_code');
            $table->integer('l2');
            $table->integer('uid');
            $table->integer('company_id');
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
        Schema::dropIfExists('level3');
    }
}
