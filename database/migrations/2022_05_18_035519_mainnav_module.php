<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MainnavModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mainnavmodule', function (Blueprint $table) {
            $table->bigInteger('module_id')->autoIncrement();
            $table->string('module_name');
            $table->string('module_icon');
            $table->string('module_rights');
            $table->integer('is_visible');
            $table->integer('sort_order');
            $table->integer('display');
            $table->integer('company_id');
            $table->integer('uid');
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
        Schema::dropIfExists('mainnavmodule');
    }
}
