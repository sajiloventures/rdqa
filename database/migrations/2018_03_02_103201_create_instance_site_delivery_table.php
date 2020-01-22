<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstanceSiteDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance_site_delivery', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('facility_user_id');
            $table->integer('created_by');
            $table->integer('instance_id');
            $table->integer('facility_id')->nullable()->comment('Facility for data verification');
            $table->string('province_name', 255)->nullable();
            $table->string('district_name', 255)->nullable();
            $table->string('palika_name', 255)->nullable();
            $table->string('facility_name', 255)->nullable()->comment('Health posts or hospitals name');
            $table->string('facility_code', 255)->nullable()->comment('Health posts or hospitals code');
            $table->string('interviewed_persons', 255)->nullable()->comment('Health posts or hospitals interviewed persons');
            $table->date('entry_date')->nullable();
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
        Schema::dropIfExists('instance_site_delivery');
    }
}
