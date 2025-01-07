<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_details', function (Blueprint $table) {
            $table->id();
            $table->string('salutation')-> nullable();
            $table->string('name');
            $table->string('ProfilePicture') -> nullable();
            $table->string('country')-> nullable();
            $table->string('mobileDialCode') -> nullable();
            $table->string('mobile')-> nullable();
            $table->string('gender')-> nullable();
            $table->string('companyName')-> nullable();
            $table->string('officialWebsite')-> nullable();
            $table->string('gstNumber')-> nullable();
            $table->string('officePhone')-> nullable();
            $table->string('city')-> nullable();
            $table->string('state')-> nullable();
            $table->string('postalCode')-> nullable();
            $table->string('companyAddress')-> nullable();
            $table->string('shippingAddress')-> nullable();
            $table->string('note') -> nullable();
            $table->string('logo')-> nullable();
            $table->string('userId') -> nullable();
            

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
        Schema::dropIfExists('client_details');
    }
};
