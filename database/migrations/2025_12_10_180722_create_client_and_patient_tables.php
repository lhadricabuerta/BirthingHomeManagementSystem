<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Client table
        Schema::create('client', function (Blueprint $table) {
            $table->id();
            $table->string('messenger_id', 50)->unique()->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('client_phone', 20);
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('address')->onDelete('set null');
        });

        // Patient table
        Schema::create('patient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('client')->onDelete('cascade');
            $table->string('patient_id', 50)->unique();
            $table->unsignedBigInteger('marital_status_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->integer('age')->nullable();
            $table->string('spouse_fname', 100)->nullable();
            $table->string('spouse_lname', 100)->nullable();
            $table->timestamps();

            $table->foreign('marital_status_id')->references('id')->on('marital_status')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
        });

        // Appointment table
        Schema::create('appointment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('client')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('status_id')->default(1);
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('appointment_reason');
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('restrict');
            $table->foreign('status_id')->references('id')->on('appointment_status')->onDelete('restrict');
        });

        // Emergency table
        Schema::create('emergency', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('branch_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency');
        Schema::dropIfExists('appointment');
        Schema::dropIfExists('patient');
        Schema::dropIfExists('client');
    }
};
