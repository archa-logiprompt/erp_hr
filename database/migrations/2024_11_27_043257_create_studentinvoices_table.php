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
        Schema::create('studentinvoices', function (Blueprint $table) {
            $table->id();

            // Foreign key for students table
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')
                  ->references('id')
                  ->on('students')
                  ->onDelete('cascade');

            $table->date('invoicedate')->nullable();
            $table->string('transactionmethod');
            $table->string('transactionid')->nullable()->unique();
            $table->string('invoiceno')->unique();
            $table->string('notes')->nullable();
            $table->string('description')->nullable();
            $table->string('generatedby')->nullable();
            $table->string('bankaccount')->nullable();
            $table->decimal('balanceamount', 10, 2)->nullable();

            // Financial details
            $table->decimal('unitprice', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->decimal('gst', 10, 2);
            $table->decimal('total_amount', 10, 2);

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
        Schema::dropIfExists('studentinvoices');
    }
};
