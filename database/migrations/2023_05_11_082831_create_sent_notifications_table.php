<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->nullable()->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->text('body_ar')->nullable();
            $table->text('body_en')->nullable();
            $table->text('qr_code')->nullable();
            $table->string('share_data')->nullable();
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
        Schema::dropIfExists('sent_notifications');
    }
}
