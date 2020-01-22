<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstanceIndicatorCrossCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance_indicator_cross_check', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('instance_id');
            $table->integer('instance_indicator_id');
            $table->integer('cross_check_1_a_id')->nullable();
            $table->integer('cross_check_1_b_id')->nullable();
            $table->integer('cross_check_2_a_id')->nullable();
            $table->integer('cross_check_2_b_id')->nullable();
            $table->integer('cross_check_3_a_id')->nullable();
            $table->integer('cross_check_3_b_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instance_indicator_cross_check');
    }
}
