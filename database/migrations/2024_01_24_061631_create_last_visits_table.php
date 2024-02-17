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
        Schema::create('last_visits', function (Blueprint $table) {
            $table->id();
            $table->date('last_visit_date');
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('create_user_id')->constrained('users');
            $table->timestamp('created_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('last_visits');
    }
};
