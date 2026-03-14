<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Bio-data 
            $table->string('name');
            $table->string('sex');
            $table->date('birthdate');
            
            // Contact 
            $table->string('mobile_number');
            $table->string('email');
            
            // Financials 
            $table->decimal('parents_gross_income', 10, 2);
            $table->boolean('is_income_flagged')->default(false); // System Logic: Must flag if income exceeds PhP 400,000.00
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_applications');
    }
};