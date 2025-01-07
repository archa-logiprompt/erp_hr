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
        Schema::create('client_invoice_details', function (Blueprint $table) {
            $table->id();

            $table->date('invoiceDate');
            $table->string('clientName');
            $table->string('project');
            $table->string('transactionMethod');
            $table->string('transactionId')->unique()->nullable();
            $table->string('invoiceNumber')->unique();
            $table->json('transactionTitle'); // Changed to JSON
            $table->json('unitPrice');       // Changed to JSON
            $table->json('description')->nullable(); // Changed to JSON
            $table->decimal('total', 10, 2);
            $table->text('note')->nullable();
            $table->string('document')->nullable();

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
        Schema::dropIfExists('client_invoice_details');
    }
};
