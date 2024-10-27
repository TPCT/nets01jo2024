<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientJourneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_journeys', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->nullable()->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->bigInteger('journey_id')->nullable()->unsigned();
            $table->foreign('journey_id')->references('id')->on('journeys')->onDelete('cascade');
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
        Schema::dropIfExists('client_journeys');
    }
}
