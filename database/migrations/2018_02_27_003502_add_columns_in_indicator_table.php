<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInIndicatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indicator', function (Blueprint $table) {
            $table->dropColumn('theme_id');
            $table->string('program', 255)->after('id');
            $table->string('code', 255)->nullable()->after('name');
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
        Schema::table('indicator', function (Blueprint $table) {
            $table->integer('theme_id')->nullable();
            $table->dropColumn(['program', 'created_at', 'updated_at']);
        });
    }
}
