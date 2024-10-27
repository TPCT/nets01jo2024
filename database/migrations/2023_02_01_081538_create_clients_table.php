<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('country_code' , 5 )->nullable();
            $table->string('phone' , 25 )->nullable();
            $table->string('work_mobile' , 25 )->nullable();
            $table->string('home_mobile' , 25 )->nullable();
            $table->string('linkedin_id')->nullable()->unique();
            $table->string('apple_id')->nullable()->unique();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->text('company_name')->nullable();
            $table->string('image')->nullable();
            $table->double('lat' ,25 , 20 )->nullable();
            $table->double('lng' ,25 , 20 )->nullable();
            $table->string('fcm_token')->nullable();
            $table->tinyInteger('mobile_id')->nullable()->comment('0 => android , 1 => ios');
            $table->string('forget_code' , 100 )->nullable();
            $table->tinyInteger('status')->default(1)->comment('-1 => blocked or deleted , 0 => not active , 1 => active');
            $table->tinyInteger('share_data')->default(1)->comment('0 => private , 1 => public');
            $table->string('street_name')->nullable();
            $table->string('building_no')->nullable();
            $table->string('office_no')->nullable();
            $table->text('other_details')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('office_country_code' , 5)->nullable();
            $table->string('office_phone' , 25)->nullable();
            $table->string('office_fax')->nullable();
            $table->string('p_o_pox')->nullable();
            $table->string('zip_code' , 25)->nullable();
            $table->text('details')->nullable();
            $table->string('lang')->nullable();
            $table->string('otp_code')->nullable();
            $table->text('qr_code')->nullable();
            $table->string('qr_code_user')->unique()->nullable();
            $table->bigInteger('country_id')->nullable()->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->bigInteger('city_id')->nullable()->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->bigInteger('job_title_id')->nullable()->unsigned();
            $table->foreign('job_title_id')->references('id')->on('job_titles')->onDelete('cascade');
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
        Schema::dropIfExists('clients');
    }
}
