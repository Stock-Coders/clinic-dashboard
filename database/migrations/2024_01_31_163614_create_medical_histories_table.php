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
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->longText('notes');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments');
            $table->foreignId('prescription_id')->nullable()->constrained('prescriptions');
            $table->foreignId('treatment_id')->nullable()->constrained('treatments');
            $table->foreignId('prescription_treatment_id')->nullable()->constrained('prescriptions_treatments');
            $table->foreignId('create_user_id')->constrained('users');
            $table->foreignId('update_user_id')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};
