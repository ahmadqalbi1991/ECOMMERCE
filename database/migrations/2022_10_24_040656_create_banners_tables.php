<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('setting_id')->nullable()->unsigned();
            $table->foreign('setting_id')->references('id')->on('settings');
            $table->string('title')->nullable();
            $table->string('path')->nullable();
            $table->boolean('show_on_home')->default(1);
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
        Schema::dropIfExists('banners_tables');
    }
}
