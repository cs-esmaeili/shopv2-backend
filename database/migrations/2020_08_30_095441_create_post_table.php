<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id('post_id');
            $table->timestamps();
            $table->foreignId('person_id');
            $table->foreign('person_id')->references('person_id')->on('person');
            $table->foreignId('category_id');
            $table->foreign('category_id')->references('category_id')->on('category');
            $table->foreignId('image');
            $table->foreign('image')->references('file_id')->on('file');
            $table->boolean('status')->default(0);
            $table->string('title', 255)->unique();
            $table->mediumText('description');
            $table->longText('body');
            $table->text('meta_keywords');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
