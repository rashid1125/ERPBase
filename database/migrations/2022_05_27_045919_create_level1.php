<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevel1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level1', function (Blueprint $table) {
            $table->integer('l1')->autoIncrement();
            $table->string('name');
            $table->string('l1_code');
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
        Schema::dropIfExists('level1');
    }
}
