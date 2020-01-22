<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteDeliveryFollowupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_delivery_followup', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('instance_id');
            $table->integer('site_delivery_id');
            $table->text('weakness')->nullable()->comment('Identified Weaknesses');
            $table->text('description')->nullable()->comment('Description of action point');
            $table->text('responsible')->nullable()->comment('Responsible(s)');
            $table->string('time_line', 15)->nullable();
            $table->string('time_line_eng', 15)->nullable();
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
        Schema::dropIfExists('site_delivery_followup');
    }
}
