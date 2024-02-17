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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->enum('appointment_reason',['examination' , 'reexamination']);
            $table->string('diagnosis')->nullable();
            $table->enum('status',['scheduled', 'completed', 'canceled']);
            $table->decimal('cost', 8, 2)->default(0);
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->foreignId('doctor_id')->constrained('users');
            $table->foreignId('patient_id')->constrained('patients');
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
        Schema::dropIfExists('appointments');
    }
};
