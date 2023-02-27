<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBilluPointsInSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('allow_billu_points')->default(0);
            $table->float('allow_points')->default(0);
            $table->float('allow_points_on_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('allow_billu_points');
            $table->dropColumn('allow_points');
            $table->dropColumn('allow_points_on_price');
        });
    }
}
