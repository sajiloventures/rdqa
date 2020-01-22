<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstanceIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance_indicators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('instance_id');
            $table->integer('indicator_id')->nullable();
//            $table->string('cross_check_1')->nullable()->comment('cross check 1 indicator alternative title');
//            $table->string('cross_check_2')->nullable()->comment('cross check 2 indicator alternative title');
//            $table->string('cross_check_3')->nullable()->comment('cross check 3 indicator alternative title');
            $table->string('from_date', 15)->nullable();
            $table->string('to_date', 15)->nullable();
            $table->string('from_date_eng', 15)->nullable();
            $table->string('to_date_eng', 15)->nullable();
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
        Schema::dropIfExists('instance_indicators');
    }
}
