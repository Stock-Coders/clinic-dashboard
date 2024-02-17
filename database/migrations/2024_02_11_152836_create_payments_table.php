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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->float('amount_before_discount')->nullable();
            $table->float('amount_after_discount')->nullable();
            $table->float('discount')->nullable();
            $table->date('payment_date');
            $table->time('payment_time');
            $table->enum('payment_method', ['credit_card', 'vodafone_cash', 'cash'])->default('cash');
            // $table->enum('payment_type', ['appointment', 'treatment']);
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade')->unique();
            $table->foreignId('treatment_id')->nullable()->constrained('treatments')->onDelete('cascade')->unique();
            $table->foreignId('prescription_treatment_id')->nullable()->constrained('prescriptions_treatments')->onDelete('cascade')->unique();
            // $table->foreignId('xray_id')->nullable()->constrained('xrays')->onDelete('cascade')->unique();
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('cascade');
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
        Schema::dropIfExists('payments');
    }
};
