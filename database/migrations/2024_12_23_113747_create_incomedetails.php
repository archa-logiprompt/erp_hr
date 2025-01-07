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
        Schema::create('incomedetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('head')->nullable();
            $table->foreign('head')->references('id')->on('income_heads')->onDelete('cascade');
            $table->unsignedBigInteger('center')->nullable();
            $table->foreign('center')->references('id')->on('center')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('name')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('method')->nullable();
            $table->string('invoiceno')->nullable();


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
        Schema::dropIfExists('incomedetails');
    }
};
