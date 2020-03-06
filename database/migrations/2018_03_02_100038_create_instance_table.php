<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by');
            $table->string('name');
            $table->string('level', 255)->nullable()->comment('Instance created for province, district or municipality');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('built_stage', 20);
            $table->text('evaluation_team')->nullable();
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
        Schema::dropIfExists('instance');
    }
}
