<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Prenatal Visit table
        Schema::create('prenatal_visit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('client')->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->foreignId('prenatal_status_id')->nullable()->constrained('prenatal_status')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('remarks_id')->nullable()->constrained('remarks')->onDelete('set null');
            $table->date('lmp')->nullable();
            $table->date('edc')->nullable();
            $table->string('aog', 20)->nullable();
            $table->tinyInteger('gravida')->nullable();
            $table->tinyInteger('para')->nullable();
            $table->timestamps();
        });

        // Visit Info table
        Schema::create('visit_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prenatal_visit_id')->constrained('prenatal_visit')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->tinyInteger('visit_number');
            $table->date('visit_date');
            $table->date('next_visit_date')->nullable();
            $table->time('next_visit_time')->nullable();
            $table->timestamps();

            $table->index('branch_id', 'idx_branch_id');
        });

        // Maternal Vitals table
        Schema::create('maternal_vitals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prenatal_visit_id')->constrained('prenatal_visit')->onDelete('cascade');
            $table->smallInteger('fht')->nullable();
            $table->decimal('fh', 4, 1)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('blood_pressure', 10)->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->smallInteger('respiratory_rate')->nullable();
            $table->smallInteger('pulse_rate')->nullable();
            $table->timestamps();
        });

        // Patient Immunizations table
        Schema::create('patient_immunizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patient')->onDelete('cascade');
            $table->foreignId('prenatal_visit_id')->constrained('prenatal_visit')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->dateTime('immunized_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_immunizations');
        Schema::dropIfExists('maternal_vitals');
        Schema::dropIfExists('visit_info');
        Schema::dropIfExists('prenatal_visit');
    }
};