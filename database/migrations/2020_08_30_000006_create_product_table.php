<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id('product_id');
            $table->timestamps();
            $table->foreignId('category_id');
            $table->foreign('category_id')->references('category_id')->on('category');
            $table->string('name',255);
            $table->decimal('price',12,0);
            $table->decimal('sale_price',12,0);
            $table->tinyInteger('status');
            $table->mediumInteger('stock');
            $table->string('image_folder',255);
            $table->text('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
