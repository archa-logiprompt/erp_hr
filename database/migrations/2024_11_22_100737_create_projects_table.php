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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('shortcode')-> nullValue();
            $table->string('projectname')-> nullValue();
            $table->string('category')-> nullValue();
            $table->string('department')-> nullValue();
             $table->unsignedBigInteger('client')->nullable();
            // $table->string('client')-> nullValue();
            $table->text('summary')-> nullValue();
            $table->text('notes')-> nullValue();
            $table->date('startdate')-> nullValue();
            $table->date('deadline')-> nullValue();





            



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
        Schema::dropIfExists('projects');
    }
};
