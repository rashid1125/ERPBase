<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEtypenarrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etypenarrations', function (Blueprint $table) {
            $table->id();
            $table->string('voucherrights');
            $table->string('vr_title')->nullable();
            $table->string('vr_link')->nullable();
            $table->string('refurl')->nullable();
            $table->string('etype');
            $table->string('etype_abbreviates')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('narration')->nullable();
            $table->string('sort_by')->nullable();
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
        Schema::dropIfExists('table_etypenarrations');
    }
}
