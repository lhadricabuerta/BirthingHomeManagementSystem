<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_pdf_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patient')->onDelete('cascade');
            $table->foreignId('prenatal_visit_id')->nullable()->constrained('prenatal_visit')->onDelete('cascade');
            $table->foreignId('intrapartum_record_id')->nullable()->constrained('intrapartum_records')->onDelete('cascade');
            $table->foreignId('postpartum_record_id')->nullable()->constrained('postpartum_records')->onDelete('cascade');
            $table->foreignId('baby_registration_id')->nullable()->constrained('baby_registrations')->onDelete('cascade');
            $table->string('file_name');
            $table->longText('file_data');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_pdf_records');
    }
};
