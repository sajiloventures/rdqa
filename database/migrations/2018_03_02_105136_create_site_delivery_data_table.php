<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteDeliveryDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_delivery_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_delivery_questions_id')->comment('Site delivery questions taken Id');
            $table->integer('instance_id');
            $table->integer('indicator_id')->comment('instance selected indicator');
            $table->integer('question_id');
            $table->integer('question_list_id');
            $table->double('value')->default(0)->comment('overall value if value = yes/no : 1/0 or value_a_a');
            $table->double('value_2')->default(0)->comment('value if type is b or compare or value_a / value_a_b');
            $table->double('value_3')->default(0)->comment('value if type is c or cross check or value_b_a');
            $table->double('value_4')->default(0)->comment('value if type is c or cross check or value_b_b');
            $table->double('compare_result')->default(0);
            $table->string('answer_remark')->nullable()->comment('Each indicator remark');
            $table->text('overall_remark')->nullable()->comment('Over all remarks of question');
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
        Schema::dropIfExists('site_delivery_data');
    }
}
