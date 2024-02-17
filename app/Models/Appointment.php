<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes,
    Relations\BelongsTo,
    Relations\HasMany,
    Relations\HasOne

};

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new appointment
        static::creating(function ($appointment) {
            $appointment->create_user_id = auth()->check() ? auth()->user()->id : random_int(1, 2);
            $appointment->update_user_id = null; // Set to null to avoid accidental updates
            $appointment->created_at = now(); // Set "created_at" to current timestamp
            $appointment->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing appointment
        static::updating(function ($appointment) {
            $appointment->update_user_id = auth()->check() ? auth()->user()->id : null;
            $appointment->timestamps = false; // temporarily disable auto-timestamp update
            $appointment->updated_at = now(); // Set "updated_at" to current timestamp
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

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class);
    }

    public function treatment(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }

    public function medicalHistory(): HasOne
    {
        return $this->hasOne(MedicalHistory::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
