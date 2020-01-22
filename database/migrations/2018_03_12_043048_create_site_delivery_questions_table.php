<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteDeliveryQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_delivery_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('instance_id');
            $table->integer('site_delivery_id')->comment('Site delivery taken Id');
            $table->integer('question_id')->comment('Each question format id');
            $table->integer('question_list_id')->comment('Each question list id');
            $table->string('question_type')->nullable()->comment('yes-no, compare or yes-no-partly');
            $table->string('part');
            $table->string('type')->nullable();
            $table->string('sub_type')->nullable();
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
        Schema::dropIfExists('site_delivery_questions');
    }
}
