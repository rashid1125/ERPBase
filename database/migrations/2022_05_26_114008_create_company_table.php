<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->integer('company_id')->autoIncrement();
            $table->string('company_name');
            $table->string('contact_person')->nullable();
            $table->string('contact')->nullable();
            $table->string('img')->nullable();
            $table->string('heading')->nullable();
            $table->string('foot_note')->nullable();
            $table->string('address')->nullable();
            $table->string('barcode_print')->nullable();
            $table->integer('allowed_users')->default(2);
            $table->integer('status')->default(1);
            $table->dateTime('expiry_date');
            $table->dateTime('date');
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
        Schema::dropIfExists('company');
    }
}
