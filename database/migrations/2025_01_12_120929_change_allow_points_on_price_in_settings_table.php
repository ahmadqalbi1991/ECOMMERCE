<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeAllowPointsOnPriceInSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `settings` CHANGE `allow_points_on_price` `allow_points_on_price` DOUBLE(8,2) NULL DEFAULT '0';");
        DB::statement("ALTER TABLE `settings` CHANGE `allow_points` `allow_points` DOUBLE(8,2) NULL DEFAULT '0.00';");
    }
}
