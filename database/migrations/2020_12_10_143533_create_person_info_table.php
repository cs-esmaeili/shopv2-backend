<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_info', function (Blueprint $table) {
            $table->id('person_info_id');
            $table->timestamps();
            $table->foreignId('person_id');
            $table->foreign('person_id')->references('person_id')->on('person');
            $table->foreignId('file_id');
            $table->foreign('file_id')->references('file_id')->on('file');
            $table->string('name', 255);
            $table->string('family', 255);
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
        Schema::dropIfExists('person_info');
    }
}
