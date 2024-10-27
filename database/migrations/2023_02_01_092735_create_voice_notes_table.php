<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoiceNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voice_notes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->nullable()->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->bigInteger('friend_id')->nullable()->unsigned();
            $table->foreign('friend_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('voice_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voice_notes');
    }
}
