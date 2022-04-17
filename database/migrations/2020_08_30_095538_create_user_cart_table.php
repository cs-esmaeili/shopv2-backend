<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_cart', function (Blueprint $table) {
            $table->id('user_cart_id');
            $table->timestamps();
            $table->foreignId('person_id');
            $table->foreign('person_id')->references('person_id')->on('person');
            $table->foreignId('product_id');
            $table->foreign('product_id')->references('product_id')->on('product');
            $table->mediumInteger('number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_cart');
    }
}
