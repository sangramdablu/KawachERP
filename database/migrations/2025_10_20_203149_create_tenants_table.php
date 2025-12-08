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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->string('code')->unique();
            $table->string('database');
            $table->string('username');
            $table->string('password');
            $table->string('host')->default('127.0.0.1');
            $table->string('port')->default('3306');

            $table->string('affiliation_no')->nullable();
            $table->string('school_type')->nullable();
            $table->text('address')->nullable();
            $table->string('pincode')->nullable();

            $table->string('principal_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone', 15)->nullable();
            $table->string('admin_username')->nullable();
            $table->string('admin_password'); // store hashed password

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
