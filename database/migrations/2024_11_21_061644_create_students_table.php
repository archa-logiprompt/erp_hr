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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('studentname');
            $table->string('email')->unique(); // Ensure unique email
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->decimal('fees', 10, 2); // Use decimal for monetary values
            $table->bigInteger('admissionnumber')->unique(); // Add unique constraint if needed
            $table->bigInteger('stedadmissionnumber')->nullable(); // Make nullable if optional
            $table->date('admissiondate');
            $table->enum('gender', ['male', 'female', 'other']); // Restrict values for gender
            $table->string('mobile', 15); // Use string for phone numbers
            $table->string('gstno', 15)->nullable(); // GST numbers are alphanumeric
            $table->string('aadhar', 12)->unique(); // Aadhar is 12 digits and unique
            $table->string('additionalcontactno', 15)->nullable(); // Optional contact number
            $table->text('address')->nullable(); // Allow for long addresses
            $table->string('image')->nullable(); // Store image file paths or URLs
            $table->string('file')->nullable(); // Store file paths or URLs
            $table->text('description')->nullable(); // Allow long descriptions
            $table->integer('frequency')->nullable(); // Default value for frequency
    
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
        Schema::dropIfExists('students');
    }
};
