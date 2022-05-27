<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_configuration', function (Blueprint $table) {
            $table->id();
            $table->integer('cash');
            $table->integer('purchase');
            $table->integer('purchasereturn');
            $table->integer('sale');
            $table->integer('salereturn');
            $table->integer('tax');
            $table->integer('expenses');
            $table->integer('discount');
            $table->integer('freight');
            $table->integer('itemdiscount');
            $table->integer('income');
            $table->integer('inventory');
            $table->integer('cost');
            $table->string('sup_party');
            $table->integer('gainlossincome');
            $table->integer('hsditem');
            $table->integer('superitem');
            $table->integer('altronxitem');
            $table->integer('hobcitem');
            $table->integer('comm_acc');
            $table->string('incomelevel');
            $table->integer('nozel_acc');
            $table->string('bank_level');
            $table->integer('gainloss');
            $table->integer('cashpos');
            $table->integer('failedattempts');
            $table->integer('fn_id');
            $table->integer('otp_time');
            $table->integer('cngitem');
            $table->integer('rate_change_account');
            $table->string('debitor_level');
            $table->string('fuelsale');
            $table->string('cashflow');
            $table->string('operatinglevel');
            $table->string('expenseslevel');
            $table->string('paylevel');
            $table->string('reclevel');
            $table->string('photo');
            $table->string('creditlimit');
            $table->string('app_version');
            $table->string('app_new_version');
            $table->string('date_format_php');
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
        Schema::dropIfExists('setting_configuration');
    }
}
