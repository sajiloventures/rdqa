<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionDetailColumnInSiteDeliveryQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_delivery_questions', function (Blueprint $table) {
            $table->longText('question_detail')->nullable()->after('question_list_id')->comment('Add questions all detail in serialize form for future use');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_delivery_questions', function (Blueprint $table) {
            $table->dropColumn(['question_detail']);
        });
    }
}
