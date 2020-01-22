<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteDeliverySystemAssessmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_delivery_system_assessment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_delivery_questions_id')->comment('Site delivery questions taken Id');
            $table->integer('instance_id');
            $table->integer('question_id');
            $table->integer('question_list_id');
            $table->integer('value')->nullable()->comment('value may be 0, 1, 2 or 3');
            $table->text('remarks')->nullable()->comment('Answer remarks');
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
        Schema::dropIfExists('site_delivery_system_assessment');
    }
}
