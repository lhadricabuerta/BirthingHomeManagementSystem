<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Inventory Items table
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name', 150);
            $table->unsignedBigInteger('category_id');
            $table->string('batch_no', 100)->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('quantity')->default(0);
            $table->unsignedBigInteger('unit_id');
            $table->integer('reorder_level')->default(10);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->index('item_name', 'idx_item_name');
        });

        // Patient Medications table
        Schema::create('patient_medications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patient')->onDelete('cascade');
            $table->timestamp('prescribed_at')->useCurrent();
            $table->text('notes')->nullable();
        });

        // Patient Medication Items table
        Schema::create('patient_medication_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_medication_id')->constrained('patient_medications')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('inventory_items')->onDelete('restrict');
            $table->integer('quantity');
        });

        // Patient Immunization Items table
        Schema::create('patient_immunization_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_immunization_id')->constrained('patient_immunizations')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('inventory_items')->onDelete('cascade');
            $table->integer('quantity')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_immunization_items');
        Schema::dropIfExists('patient_medication_items');
        Schema::dropIfExists('patient_medications');
        Schema::dropIfExists('inventory_items');
    }
};
