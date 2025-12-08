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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->date('dob');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone', 15)->nullable();
            $table->string('enrollment_number', 100)->nullable();
            $table->date('admission_date');
            $table->string('grade', 50)->nullable();
            $table->string('section', 50)->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended', 'graduated'])->default('active');
            $table->boolean('is_deleted')->default(false);
            $table->dateTime('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->string('profile_picture')->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->text('medical_conditions')->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('religion', 100)->nullable();
            $table->string('language_preference', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
