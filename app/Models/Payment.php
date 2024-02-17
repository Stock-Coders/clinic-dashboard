<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo,
    Relations\HasOne
};

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new payment
        static::creating(function ($payment) {
            $payment->create_user_id = auth()->check() ? auth()->user()->id : random_int(1, 2);
            $payment->update_user_id = null; // Set to null to avoid accidental updates
            $payment->created_at = now(); // Set "created_at" to current timestamp
            $payment->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing payment
        static::updating(function ($payment) {
            $payment->update_user_id = auth()->check() ? auth()->user()->id : null;
            $payment->timestamps = false; // temporarily disable auto-timestamp update
            $payment->updated_at = now(); // Set "updated_at" to current timestamp
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

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }

    public function prescriptionTreatment(): BelongsTo
    {
        return $this->belongsTo(PrescriptionTreatment::class, 'prescription_treatment_id', 'id');
    }

    // public function xray(): BelongsTo
    // {
    //     return $this->belongsTo(XRay::class, 'xray_id', 'id');
    // }

    public function xrays()
    {
        return $this->belongsToMany(XRay::class, 'payment_xray', 'payment_id', 'xray_id')->withTimestamps();
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    // public function receipt(): HasOne
    // {
    //     return $this->hasOne(Receipt::class);
    // }
}
