<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_title')->nullable();
            $table->string('sku_code')->unique('sku_code')->nullable();
            $table->enum('product_type', ['simple', 'variant'])->nullable();
            $table->double('price')->default(0)->nullable();
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->mediumText('allergy_info')->nullable();
            $table->mediumText('storage_info')->nullable();
            $table->bigInteger('category_id')->nullable()->unsigned();
            $table->bigInteger('brand_id')->nullable()->unsigned();
            $table->string('slug')->nullable()->unique();
            $table->boolean('apply_discount')->default(0)->nullable();
            $table->enum('discount_type', ['percentage', 'value'])->nullable();
            $table->double('discount_value')->default(0)->nullable();
            $table->bigInteger('unit_id')->nullable()->unsigned();
            $table->double('unit_value')->default(0)->nullable();
            $table->double('quantity')->default(0)->nullable();
            $table->boolean('allow_add_to_cart_when_out_of_stock')->default(0)->nullable();
            $table->string('default_image')->nullable();
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
        Schema::dropIfExists('products');
    }
}
