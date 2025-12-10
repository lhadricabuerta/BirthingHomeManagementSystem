<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Patient Deliveries table
        Schema::create('patient_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patient');
            $table->foreignId('delivery_status_id')->nullable()->constrained('delivery_status')->onDelete('set null');
            $table->foreignId('staff_id')->nullable()->constrained('staff');
            $table->foreignId('prenatal_visit_id')->nullable()->constrained('prenatal_visit')->onDelete('set null');
            $table->timestamps();
        });

        // Intrapartum Records table
        Schema::create('intrapartum_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained('patient_deliveries')->onDelete('cascade');
            $table->foreignId('remarks_id')->nullable()->constrained('remarks')->onDelete('set null');
            $table->string('bp', 20)->nullable();
            $table->string('temp', 10)->nullable();
            $table->string('rr', 20)->nullable();
            $table->string('pr', 20)->nullable();
            $table->string('fundic_height', 20)->nullable();
            $table->string('fetal_heart_tone', 20)->nullable();
            $table->string('internal_exam', 50)->nullable();
            $table->enum('bag_of_water', ['intact', 'ruptured'])->nullable();
            $table->enum('baby_delivered', ['yes', 'no'])->nullable();
            $table->enum('placenta_delivered', ['yes', 'no'])->nullable();
            $table->enum('baby_sex', ['male', 'female'])->nullable();
            $table->timestamps();
        });

        // Postpartum Records table
        Schema::create('postpartum_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained('patient_deliveries')->onDelete('cascade');
            $table->foreignId('remarks_id')->nullable()->constrained('remarks')->onDelete('set null');
            $table->string('postpartum_bp', 20)->nullable();
            $table->string('postpartum_temp', 10)->nullable();
            $table->string('postpartum_rr', 20)->nullable();
            $table->string('postpartum_pr', 20)->nullable();
            $table->string('newborn_weight', 20)->nullable();
            $table->string('newborn_hc', 20)->nullable();
            $table->string('newborn_cc', 20)->nullable();
            $table->string('newborn_ac', 20)->nullable();
            $table->string('newborn_length', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postpartum_records');
        Schema::dropIfExists('intrapartum_records');
        Schema::dropIfExists('patient_deliveries');
    }
};