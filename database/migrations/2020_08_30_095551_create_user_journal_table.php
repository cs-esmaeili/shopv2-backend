<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_journal', function (Blueprint $table) {
            $table->id('user_journal_id');
            $table->timestamps();
            $table->foreignId('person_id');
            $table->foreign('person_id')->references('person_id')->on('person');
            $table->string('ref_id',255);
            $table->string('authority_code',255);
            $table->boolean('done');
            $table->decimal('price',12,0);
            $table->string('postal_code',10);
            $table->string('name',255);
            $table->string('phone_number',255);
            $table->string('state',50);
            $table->string('city',50);
            $table->mediumText('address');
            $table->mediumText('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_journal');
    }
}
