<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_applications', function (Blueprint $table) {
            $table->id();
            // This securely links the application to the logged-in user
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 

            // --- 2.1 Personal Information ---
            $table->string('name'); // Usually carried over from the user table during initial creation
            $table->string('email'); // Carried over from user
            $table->string('maiden_name')->nullable();
            $table->string('sex')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->string('municipality')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();
            $table->string('tribal_membership')->nullable();
            $table->string('disability')->nullable();

            // --- 2.2 Academic Profile ---
            $table->string('school_name')->nullable();
            $table->string('school_address')->nullable();
            $table->string('school_sector')->nullable();
            $table->string('student_id_number')->nullable();
            $table->string('year_level')->nullable();

            // --- 2.3 Family & Financial Background ---
            $table->string('father_name')->nullable();
            $table->string('father_status')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_status')->nullable();
            $table->string('mother_occupation')->nullable();
            // Decimal format allows for monetary values (up to 99,999,999.99)
            $table->decimal('total_parents_gross_income', 10, 2)->nullable(); 
            $table->integer('number_of_siblings')->nullable();
            $table->boolean('existing_financial_assistance')->default(false);
            $table->boolean('is_income_flagged')->default(false);

            // --- 2.4 Digital Documents ---
            $table->string('id_picture_path')->nullable();
            $table->string('cor_coe_path')->nullable();
            $table->string('indigency_certificate_path')->nullable();
            
            // Admin Status (For your Admin Dashboard feature)
            $table->string('status')->default('Pending');
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_applications');
    }
};