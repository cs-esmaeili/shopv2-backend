<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserJournalProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_journal_product', function (Blueprint $table) {
            $table->id('user_journal_product_id');
            $table->timestamps();
            $table->foreignId('user_journal_id');
            $table->foreign('user_journal_id')->references('user_journal_id')->on('user_journal');
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
        Schema::dropIfExists('user_journal_product');
    }
}
