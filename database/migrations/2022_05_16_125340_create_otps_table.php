<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otp', function (Blueprint $table) {
            $table->id();
            $table->dateTime('otp_date');
            $table->string('otp_token')->nullable();
            $table->integer('otp_code')->nullable();
            $table->integer('otp_expired')->nullable();
            $table->integer('otp_code_attempt')->nullable();
            $table->integer('otp_uid')->nullable();
            $table->string('otp_uname')->nullable();
            $table->integer('otp_fn_id')->nullable();
            $table->integer('otp_company_id')->nullable();
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
        Schema::dropIfExists('otp');
    }
}
