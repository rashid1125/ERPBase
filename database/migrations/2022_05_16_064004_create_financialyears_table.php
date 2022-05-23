<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialyearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financialyear', function (Blueprint $table) {
            $table->bigInteger('financialyear_id')->autoIncrement();
            $table->string('financialyear_name');
            $table->string('financialyear_remarks');
            $table->dateTime('financialyear_start_date');
            $table->dateTime('financialyear_end_date');
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
        Schema::dropIfExists('financialyear');
    }
}
