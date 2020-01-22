<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProvinceDistrictUserIdInUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('province_user_id')->nullable()->after('id');
            $table->integer('district_user_id')->nullable()->after('province_user_id');
            $table->boolean('hf_user')->default(0)->after('district_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['province_user_id', 'district_user_id', 'hf_user']);
        });
    }
}
