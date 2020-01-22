<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility', function (Blueprint $table) {
            $table->increments('id');
            $table->string('province_code')->nullable();
            $table->string('province_name');
            $table->string('district_code')->nullable();
            $table->string('district_name');
            $table->string('palika_code')->nullable();
            $table->string('palika_name');
            $table->string('ward_code')->nullable();
            $table->string('ward_name');
            $table->string('hf_id')->nullable();
            $table->string('hf_code')->nullable();
            $table->string('hf_name')->nullable();
            $table->string('hf_type')->nullable();
            $table->string('ownership_type')->nullable();
            $table->string('urban_rural')->nullable();
            $table->string('geography')->nullable();
            $table->string('public_nonpublic')->nullable();
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
        Schema::dropIfExists('facility');
    }
}
