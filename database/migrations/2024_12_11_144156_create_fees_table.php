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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
    $table->string('title')->nullable(); // Allow 'title' to be nullable
    $table->json('subtitle')->nullable(); // Allow 'subtitle' to be nullable
    $table->json('splitup')->nullable(); // Allow 'splitup' to be nullable
    $table->json('taxes')->nullable(); // Allow 'taxes' to be nullable
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
        Schema::dropIfExists('fees');
    }
};
