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
        Schema::create('analyses', function (Blueprint $table) {
            $table->id();
            $table->string('medical_lab_name');
            $table->string('analysis_type');
            $table->date('analysis_date');
            $table->time('analysis_time');
            $table->longText('recommendations')->nullable();
            $table->longText('notes')->nullable();
            $table->foreignId('doctor_id')->constrained('users');
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('create_user_id')->constrained('users');
            $table->foreignId('update_user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
