<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTitleTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_title_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('job_title_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['job_title_id', 'locale']);
            $table->foreign('job_title_id')->references('id')->on('job_titles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_title_translations');
    }
}
