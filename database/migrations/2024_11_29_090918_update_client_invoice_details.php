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
        //
        Schema::table('client_invoice_details', function (Blueprint $table) {
            
            $table->json('amount')->nullable();
            $table->json('gsts')->nullable();
            $table->string('bankAccount')->nullable();
            $table->decimal('gstamount')->nullable();
            $table->decimal('subtotal')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_invoice_details');
    }
};
