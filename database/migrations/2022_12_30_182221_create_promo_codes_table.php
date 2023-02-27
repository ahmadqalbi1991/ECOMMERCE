<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->date('validity_from')->nullable();
            $table->date('validity_to')->nullable();
            $table->boolean('is_active')->default(0);
            $table->boolean('is_published')->default(0);
            $table->text('description')->default(0);
            $table->string('consumption')->nullable();
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
        Schema::dropIfExists('promo_codes');
    }
}
