<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('province', 100)->nullable()->after('email');
            $table->string('district', 255)->nullable()->after('province');
            $table->string('municipality', 255)->nullable()->after('district');
            $table->string('health_post_name', 255)->nullable()->after('municipality');
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
            $table->dropColumn(['province', 'district', 'municipality', 'health_post_name']);
        });
    }
}
