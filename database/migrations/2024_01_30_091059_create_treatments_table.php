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
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->string('procedure_name');
            $table->enum('treatment_type',['surgical','medical' , 'preventive']);
            $table->enum('status',['scheduled', 'completed', 'canceled']);
            $table->decimal('cost', 8, 2)->default(0);
            $table->date('treatment_date');
            $table->time('treatment_time');
            $table->longText('notes')->nullable();
            $table->foreignId('prescription_id')->nullable()->unique()->constrained('prescriptions')->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->unique()->constrained('appointments')->onDelete('cascade');
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
        Schema::dropIfExists('treatments');
    }
};
