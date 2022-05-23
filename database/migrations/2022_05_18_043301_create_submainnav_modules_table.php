<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmainnavModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submainnavmodule', function (Blueprint $table) {
            $table->bigInteger('sub_module_id')->autoIncrement();
            $table->integer('module_id');
            $table->string('sub_module_name');
            $table->string('sub_module_icon');
            $table->integer('is_visible');
            $table->integer('sort_order');
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
        Schema::dropIfExists('submainnavmodule');
    }
}
