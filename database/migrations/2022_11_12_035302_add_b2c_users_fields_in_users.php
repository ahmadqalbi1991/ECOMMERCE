<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddB2cUsersFieldsInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'b2c', 'sub_admin', '']);
            $table->string('verification_code')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_archive')->default(0);
            $table->boolean('is_active')->default(0);
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
            $table->dropColumn('role');
            $table->dropColumn('verification_code');
            $table->dropColumn('is_verified');
            $table->dropColumn('is_archive');
        });
    }
}
