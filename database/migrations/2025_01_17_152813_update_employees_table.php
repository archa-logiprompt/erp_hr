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
    Schema::table('employees', function (Blueprint $table) {
        // Update existing fields to be nullable
        $table->string('empid')->nullable()->change();
        $table->string('country')->nullable()->change();
        $table->string('mobile')->nullable()->change();
        $table->string('gender')->nullable()->change();
        $table->string('ProfilePicture')->nullable()->change();
        $table->string('joining_date')->nullable()->change();
        $table->string('dob')->nullable()->change();
        $table->string('dep_name')->nullable()->change();
        $table->string('designation_id')->nullable()->change();
        $table->string('adhaar')->nullable()->change();
        $table->integer('loginYes')->nullable()->change();
        $table->integer('recievemailyes')->nullable()->change();
        $table->integer('hourlyrateyes')->nullable()->change();
        $table->string('acc_name')->nullable()->change();
        $table->string('account_no')->nullable()->change();
        $table->string('bank_name')->nullable()->change();
        $table->string('ifsc')->nullable()->change();
        $table->string('branch_name')->nullable()->change();
        $table->string('pg')->nullable()->change();
        $table->string('ug')->nullable()->change();
        $table->string('twelth')->nullable()->change();
        $table->string('tenth')->nullable()->change();
        $table->string('copy_adhaar')->nullable()->change();
        $table->string('employee_type')->nullable()->change();
        $table->string('user_id')->nullable()->change();
        $table->integer('status')->nullable()->change();
    });
}

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('empid')->nullable(false)->change();
        $table->string('country')->nullable(false)->change();
        $table->string('mobile')->nullable(false)->change();
        $table->string('gender')->nullable(false)->change();
        $table->string('ProfilePicture')->nullable(false)->change();
        $table->string('joining_date')->nullable(false)->change();
        $table->string('dob')->nullable(false)->change();
        $table->string('dep_name')->nullable(false)->change();
        $table->string('designation_id')->nullable(false)->change();
        $table->string('adhaar')->nullable(false)->change();
        $table->integer('loginYes')->nullable(false)->change();
        $table->integer('recievemailyes')->nullable(false)->change();
        $table->integer('hourlyrateyes')->nullable(false)->change();
        $table->string('acc_name')->nullable(false)->change();
        $table->string('account_no')->nullable(false)->change();
        $table->string('bank_name')->nullable(false)->change();
        $table->string('ifsc')->nullable(false)->change();
        $table->string('branch_name')->nullable(false)->change();
        $table->string('pg')->nullable(false)->change();
        $table->string('ug')->nullable(false)->change();
        $table->string('twelth')->nullable(false)->change();
        $table->string('tenth')->nullable(false)->change();
        $table->string('copy_adhaar')->nullable(false)->change();
        $table->string('employee_type')->nullable(false)->change();
        $table->string('user_id')->nullable(false)->change();
        $table->integer('status')->nullable(false)->change();
});
    }
};
