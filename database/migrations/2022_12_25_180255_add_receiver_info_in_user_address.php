<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceiverInfoInUserAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_address', function (Blueprint $table) {
            $table->string('receiver_name')->nullable();
            $table->string('contact_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_address', function (Blueprint $table) {
            $table->dropColumn('receiver_name');
            $table->dropColumn('contact_number');
        });
    }
}
