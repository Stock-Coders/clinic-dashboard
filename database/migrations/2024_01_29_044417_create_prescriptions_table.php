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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->string('prescription');
            $table->string('allergy')->nullable();
            $table->foreignId('appointment_id')->unique()->constrained('appointments')->onDelete('cascade');
            $table->dateTime('next_visit')->nullable();
            $table->foreignId('create_doctor_id')->constrained('users');
            $table->foreignId('update_doctor_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
