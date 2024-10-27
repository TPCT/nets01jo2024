<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_friends', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('accepted')->nullable()->default(1);
            $table->bigInteger('client_id')->nullable()->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->bigInteger('friend_id')->nullable()->unsigned();
            $table->foreign('friend_id')->references('id')->on('clients')->onDelete('cascade');
            $table->tinyInteger('share_data')->default(1)->comment('0 => private , 1 => public');
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
        Schema::dropIfExists('client_friends');
    }
}
