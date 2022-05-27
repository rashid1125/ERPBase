<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevel2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level2', function (Blueprint $table) {
            $table->integer('l2')->autoIncrement();
            $table->string('name');
            $table->string('l2_code');
            $table->integer('l1');
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
        Schema::dropIfExists('level2');
    }
}
