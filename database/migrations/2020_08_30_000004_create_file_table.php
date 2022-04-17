<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file', function (Blueprint $table) {
            $table->id('file_id');
            $table->timestamps();
            $table->string('orginal_name', 255);
            $table->string('new_name', 255)->unique();
            $table->string('hash', 255)->unique()->nullable();
            $table->mediumText('location');
            $table->foreignId('person_id');
            $table->foreign('person_id')->references('person_id')->on('person');
            $table->enum('type', ['public', 'private']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file');
    }
}
