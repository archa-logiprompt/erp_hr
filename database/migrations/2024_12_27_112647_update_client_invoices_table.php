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
        Schema::table('client_invoice_details', function (Blueprint $table) {
            if (!Schema::hasColumn('client_invoice_details', 'balance')) {
                // Add the 'balance' column
                $table->decimal('balance', 10, 2)->nullable();
            }
        });

                       

     
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_invoice_details', function (Blueprint $table) {
            if (Schema::hasColumn('client_invoice_details', 'balance')) {
                // Drop the 'balance' column
                $table->dropColumn('balance');
            }
        });
    }
};
