<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Baby Registrations table
        Schema::create('baby_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained('patient_deliveries')->onDelete('cascade');
            $table->string('baby_first_name', 100)->nullable();
            $table->string('baby_middle_name', 100)->nullable();
            $table->string('baby_last_name', 100)->nullable();
            $table->enum('sex', ['male', 'female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->time('time_of_birth')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->enum('type_of_birth', ['single', 'twin', 'triplet'])->nullable();
            $table->string('birth_order', 50)->nullable();
            $table->string('weight_at_birth', 20)->nullable();
            $table->timestamps();
        });

        // Baby Mothers table
        Schema::create('baby_mothers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('baby_registrations')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patient')->onDelete('cascade');
            $table->string('maiden_middle_name', 100)->nullable();
            $table->string('citizenship', 100)->nullable();
            $table->string('religion', 100)->nullable();
            $table->integer('total_children_alive')->nullable();
            $table->integer('children_still_living')->nullable();
            $table->integer('children_deceased')->nullable();
            $table->string('occupation', 100)->nullable();
            $table->timestamps();
        });

        // Baby Fathers table
        Schema::create('baby_fathers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('baby_registrations')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patient')->onDelete('cascade');
            $table->string('middle_name', 100)->nullable();
            $table->string('citizenship', 100)->nullable();
            $table->string('religion', 100)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->integer('age')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        // Baby Additional Info table
        Schema::create('baby_additional_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained('baby_registrations')->onDelete('cascade');
            $table->date('marriage_date')->nullable();
            $table->string('marriage_place')->nullable();
            $table->string('birth_attendant', 150)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baby_additional_info');
        Schema::dropIfExists('baby_fathers');
        Schema::dropIfExists('baby_mothers');
        Schema::dropIfExists('baby_registrations');
    }
};
