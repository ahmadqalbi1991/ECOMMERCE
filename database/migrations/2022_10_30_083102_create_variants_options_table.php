<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_variant_id')->nullable()->unsigned();
            $table->bigInteger('attribute_id')->nullable()->unsigned();
            $table->bigInteger('option_id')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variants_options');
    }
}
