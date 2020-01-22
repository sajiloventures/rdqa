<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSystemAssessmentColumnInSiteDeliveryFollowupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_delivery_followup', function (Blueprint $table) {
            $table->string('question_id')->nullable()->after('instance_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_delivery_followup', function (Blueprint $table) {
            $table->dropColumn('question_id');
        });
    }
}
