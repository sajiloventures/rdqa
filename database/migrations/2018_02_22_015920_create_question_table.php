<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('part', 50);
            $table->string('part_name', 255);
            $table->text('part_description')->nullable();
            $table->string('type', 50);
            $table->string('type_name', 255);
            $table->text('type_description')->nullable();
            $table->string('sub_type', 50)->nullable();
            $table->string('sub_type_name', 255)->nullable();
            $table->text('sub_type_description')->nullable();
            $table->integer('sort_order')->default(1);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('questions');
    }
}
