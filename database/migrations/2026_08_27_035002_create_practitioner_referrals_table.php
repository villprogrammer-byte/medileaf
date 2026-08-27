<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('practitioner_referrals', function (Blueprint $table) {

            $table->id();

            // Practitioner Details
            $table->string('practitioner_name');
            $table->string('practice_name')->nullable();
            $table->string('practitioner_email');
            $table->string('practitioner_phone');

            // Patient Details
            $table->string('patient_first_name');
            $table->string('patient_last_name');
            $table->string('patient_email');
            $table->string('patient_phone');
            $table->date('patient_dob');

            // Additional Information
            $table->string('medicare_number')->nullable();
            $table->text('notes')->nullable();

            // Status
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('practitioner_referrals');
    }
};