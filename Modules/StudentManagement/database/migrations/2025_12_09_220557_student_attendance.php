<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('student_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->date('attendance_date');
            $table->enum('status',['present','absent'])->default('present');
            
            // Audit
            $table->unsignedBigInteger('marked_by')->nullable(); // teacher/admin ID
            $table->timestamps();

            $table->unique(['student_id','attendance_date']); // prevents duplicate entries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('student_attendance');
    }
};
