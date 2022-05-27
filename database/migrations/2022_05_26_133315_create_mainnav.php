<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainnav extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mainnav', function (Blueprint $table) {
            $table->integer('mainnav_id')->autoIncrement();
            $table->integer('vrnoa');
            $table->integer('module_id');
            $table->integer('sub_module_id');
            $table->string('vr_title')->nullable();
            $table->string('vr_type')->nullable();
            $table->string('vr_rights')->nullable();
            $table->string('vr_icon')->nullable();
            $table->string('vr_post_method')->nullable();
            $table->integer('is_visible')->nullable()->default(1);
            $table->integer('sort_order')->nullable();
            $table->integer('is_tax')->nullable()->default(0);
            $table->integer('company_id')->nullable()->default(1);
            $table->integer('uid')->nullable()->default(1);
            $table->string('report_dynamically_parm')->nullable();
            $table->integer('report_id')->nullable();
            $table->integer('route_dynamic_id')->nullable();
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
        Schema::dropIfExists('mainnav');
    }
}
