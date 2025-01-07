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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('head')->nullable();
            $table->foreign('head')->references('id')->on('expensehead')->onDelete('cascade');
            $table->string('invoiceno')->nullable();
            $table->date('date')->nullable();
            $table->string('name')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('document')->nullable();
            $table->string('description')->nullable();

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
        Schema::dropIfExists('expenses');
    }
};
