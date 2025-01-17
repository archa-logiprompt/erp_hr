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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('empid');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('country');
            $table->string('mobile');
            $table->string('gender');
            $table->string('ProfilePicture');
            $table->string('joining_date');
            $table->string('dob');
            $table->string('role');
            $table->string('dep_name');
            $table->string('designation');
            $table->string('adhaar');
            $table->integer('loginYes');
            $table->integer('recievemailyes');
            $table->integer('hourlyrateyes');
            $table->string('acc_name');
            $table->string('account_no');
            $table->string('bank_name');
            $table->string('ifsc');
            $table->string('branch_name');
            $table->string('pg');
            $table->string('ug');
            $table->string('twelth');
            $table->string('tenth');
            $table->string('copy_adhaar');
            $table->integer('employee_type');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
