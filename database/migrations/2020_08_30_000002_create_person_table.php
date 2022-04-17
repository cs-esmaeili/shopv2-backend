<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person', function (Blueprint $table) {
            $table->id('person_id');
            $table->timestamps();
            $table->string('username', 255)->unique();
            $table->string('password', 255);
            $table->foreignId('role_id');
            $table->foreign('role_id')->references('role_id')->on('role');
            $table->foreignId('token_id')->unique();
            $table->foreign('token_id')->references('token_id')->on('token');
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('person');
    }
}
