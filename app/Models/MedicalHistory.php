<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes,
    Relations\BelongsTo

};

class MedicalHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "medical_histories";

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new medical history
        static::creating(function ($medicalHistory) {
            $medicalHistory->create_user_id = auth()->check() ? auth()->user()->id : random_int(1, 2);
            $medicalHistory->update_user_id = null; // Set to null to avoid accidental updates
            $medicalHistory->created_at = now(); // Set "created_at" to current timestamp
            $medicalHistory->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing medical history
        static::updating(function ($medicalHistory) {
            $medicalHistory->update_user_id = auth()->check() ? auth()->user()->id : null;
            $medicalHistory->timestamps = false; // temporarily disable auto-timestamp update
            $medicalHistory->updated_at = now(); // Set "updated_at" to current timestamp
        });
    }

    // Relationships
    public function create_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'create_user_id', 'id');
    }

    public function update_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'update_user_id', 'id');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class, 'prescription_id', 'id');
    }

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }

    public function prescriptionTreatment(): BelongsTo
    {
        return $this->belongsTo(PrescriptionTreatment::class, 'prescription_treatment_id', 'id');
    }

}
