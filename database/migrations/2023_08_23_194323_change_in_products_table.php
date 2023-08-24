<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->on('suppliers')->references('id');
            $table->float('whole_sale_price')->nullable();
            $table->float('cost_price_margin')->nullable();
            $table->float('in_hand_quantity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('supplier_id');
            $table->dropForeign('supplier_id');
            $table->dropColumn('whole_sale_price');
            $table->dropColumn('cost_price_margin');
            $table->dropColumn('in_hand_quantity');
        });
    }
}
