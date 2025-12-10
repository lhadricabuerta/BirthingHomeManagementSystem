<?php

// Migration 1: 2024_01_01_000001_create_base_tables.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'staff'])->default('staff');
            $table->boolean('is_active')->default(true);
            $table->string('two_factor_code')->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();
            $table->timestamps();
        });

        // Branch table
        Schema::create('branch', function (Blueprint $table) {
            $table->id();
            $table->string('branch_name', 100);
        });

        // Address table
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('village')->nullable();
            $table->string('city_municipality');
            $table->string('province');
            $table->timestamps();
        });

        // Marital Status table
        Schema::create('marital_status', function (Blueprint $table) {
            $table->id();
            $table->string('marital_status_name', 50);
        });

        // Categories table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
        });

        // Units table
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
        });

        // Appointment Status table
        Schema::create('appointment_status', function (Blueprint $table) {
            $table->id();
            $table->string('status_name', 50)->unique();
        });

        // Prenatal Status table
        Schema::create('prenatal_status', function (Blueprint $table) {
            $table->id();
            $table->string('status_name')->unique();
            $table->timestamps();
        });

        // Delivery Status table
        Schema::create('delivery_status', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->timestamps();
        });

        // Remarks table
        Schema::create('remarks', function (Blueprint $table) {
            $table->id();
            $table->text('notes');
            $table->timestamps();
        });

        // Password Resets table
        Schema::create('password_resets', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('remarks');
        Schema::dropIfExists('delivery_status');
        Schema::dropIfExists('prenatal_status');
        Schema::dropIfExists('appointment_status');
        Schema::dropIfExists('units');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('marital_status');
        Schema::dropIfExists('address');
        Schema::dropIfExists('branch');
        Schema::dropIfExists('users');
    }
};