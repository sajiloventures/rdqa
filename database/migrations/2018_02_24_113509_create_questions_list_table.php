<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('question_id')->nullable()->comment('parent question table id');
            $table->text('question');
            $table->string('question_note')->nullable();
            $table->string('if_not_question')->nullable();
            $table->string('compare_result')->nullable();
            $table->string('compare_type')->default('A/B');
            $table->string('question_type')->nullable();
            $table->integer('sort_order')->default(1);
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
        Schema::dropIfExists('questions_list');
    }
}
