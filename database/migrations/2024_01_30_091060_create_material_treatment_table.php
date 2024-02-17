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
        Schema::create('material_treatment', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_cost', 8, 2)->default(0);
            $table->integer('material_quantity')->nullable(); // each material quantity
            $table->foreignId('material_id')->nullable()->constrained('materials')->onDelete('cascade');
            $table->foreignId('treatment_id')->nullable()->constrained('treatments')->onDelete('cascade');
            // $table->foreignId('create_user_id')->constrained('users');
            // $table->foreignId('update_user_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_treatment');
    }
};
