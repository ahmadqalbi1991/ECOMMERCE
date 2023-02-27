<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
            $table->string('default_currency')->default('Rs');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->boolean('allow_brands')->default(0);
            $table->text('facebook_url')->nullable();
            $table->text('instagram_url')->nullable();
            $table->text('twitter_url')->nullable();
            $table->text('linkedin_url')->nullable();
            $table->text('youtube_url')->nullable();
            $table->string('ntn_number')->nullable();
            $table->string('strn_number')->nullable();
            $table->longText('about_us')->nullable();
            $table->longText('privacy_policy')->nullable();
            $table->longText('terms_and_conditions')->nullable();
            $table->longText('refund_policy')->nullable();
            $table->boolean('allow_refund_policy')->default(0);
            $table->string('contact_number')->nullable();
            $table->string('contact_email')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
