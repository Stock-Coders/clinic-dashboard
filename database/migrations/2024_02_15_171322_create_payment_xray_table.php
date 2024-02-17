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
        Schema::create('payment_xray', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('cascade');
            $table->foreignId('xray_id')->nullable()->constrained('xrays')->onDelete('cascade');
            $table->timestamps();

            // Ensuring that each pair of "payment_id" and "xray_id" must be unique together (not individually).
            $table->unique(['payment_id', 'xray_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_xray');
    }
};
