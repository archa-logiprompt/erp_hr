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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); 
            $table->integer('invoiceNumber')->unique(); 
            $table->unsignedBigInteger('invoiceid')->nullable();
            $table->timestamps(); 

            $table->foreign('invoiceid')
                ->references('id')
                ->on('client_invoice_details')
                ->onDelete('cascade'); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
