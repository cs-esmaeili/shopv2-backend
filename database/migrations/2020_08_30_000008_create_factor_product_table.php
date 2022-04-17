<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor_product', function (Blueprint $table) {
            $table->id('factor_product');
            $table->timestamps();
            $table->foreignId('factor_id');
            $table->foreign('factor_id')->references('factor_id')->on('factor');
            $table->foreignId('product_id');
            $table->foreign('product_id')->references('product_id')->on('product');
            $table->mediumInteger('number');
            $table->decimal('price',12,0);
            $table->decimal('sale_price',12,0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factor_product');
    }
}
