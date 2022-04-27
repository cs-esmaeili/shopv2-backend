<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor', function (Blueprint $table) {
            $table->id('factor_id');
            $table->timestamps();
            $table->foreignId('person_id');
            $table->foreign('person_id')->references('person_id')->on('person');
            $table->foreignId('person_address_id');
            $table->foreign('person_address_id')->references('person_address_id')->on('person_address');
            $table->string('ref_id',255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factor');
    }
}
