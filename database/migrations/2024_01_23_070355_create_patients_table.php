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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('chief_complaint', ['badly_aesthetic', 'severe_pain', 'mastication']);
            $table->string('chronic_disease')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('emergency_phone')->unique()->nullable();
            $table->string('whatsapp')->nullable();
            $table->date('dob');
            $table->enum('gender', ['male', 'female']);
            $table->longText('address')->nullable();
            // $table->longText('insurance_info')->nullable();
            $table->foreignId('create_user_id')->constrained('users');
            $table->foreignId('update_user_id')->nullable()->constrained('users');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
