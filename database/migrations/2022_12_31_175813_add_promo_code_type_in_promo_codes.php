<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromoCodeTypeInPromoCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->enum('promo_code_type', ['percentage', 'price']);
            $table->float('value')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promo_codes', function (Blueprint $table) {
            $table->dropColumn('promo_code_type');
            $table->dropColumn('value');
        });
    }
}
