<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patient_prescriptions', function (Blueprint $table) {
            $table->id();

            // Patient link
            $table->string('halaxy_patient_id')->index();

            // Prescription details
            $table->string('ihi_id')->nullable();
            $table->string('prescription_number');

            // Medicine details
            $table->string('medicine_name');
            $table->string('strength_form')->nullable();
            $table->text('directions')->nullable();
            $table->string('quantity')->nullable();
            $table->unsignedInteger('repeats')->default(0);
            $table->string('interval')->nullable();

            // Prescription status
            $table->string('status')->default('active');

            $table->timestamps();

            $table->index(
                ['halaxy_patient_id', 'created_at'],
                'patient_prescriptions_patient_created_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_prescriptions');
    }
};