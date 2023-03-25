<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsInBanners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->bigInteger('deal_id')->nullable()->unsigned();
            $table->string('content_heading')->nullable();
            $table->text('content')->nullable();
            $table->boolean('redirect_to_deal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('deal_id');
            $table->dropColumn('content_heading');
            $table->dropColumn('content');
            $table->dropColumn('redirect_to_deal');
        });
    }
}
