<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigInteger('uid')->autoIncrement();
            $table->string('fullname');
            $table->string('uname')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('pass');
            $table->string('mobile')->nullable();
            $table->string('photo')->nullable();
            $table->string('user_can_login_fn')->nullable();
            $table->string('level3_id')->nullable();
            $table->integer('failedattempts')->nullable()->default(0);
            $table->integer('report_to_user')->nullable()->default(1);
            $table->integer('is_secure')->default(1);
            $table->integer('rgid');
            $table->integer('company_id');
            $table->integer('uuid')->default(1);
            $table->integer('send_mail')->nullable()->default(0);
            $table->dateTime('date');
            $table->rememberToken();
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
        Schema::dropIfExists('user');
    }
}
