<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeildsInOrderSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_sessions', function (Blueprint $table) {
            $table->float('sub_total')->nullable()->default(0);
            $table->float('tax')->nullable()->default(0);
            $table->float('delivery_charges')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_sessions', function (Blueprint $table) {
            $table->dropColumn('sub_total');
            $table->dropColumn('tax');
            $table->dropColumn('delivery_charges');
        });
    }
}
