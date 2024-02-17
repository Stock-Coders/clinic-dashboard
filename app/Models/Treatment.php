<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo,
    Relations\HasOne,
    Relations\BelongsToMany,
    // Relations\HasMany
};

class Treatment extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new treatment
        static::creating(function ($treatment) {
            $treatment->create_user_id = auth()->check() ? auth()->user()->id : random_int(1, 2);
            $treatment->update_user_id = null; // Set to null to avoid accidental updates
            $treatment->created_at = now(); // Set "created_at" to current timestamp
            $treatment->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing treatment
        static::updating(function ($treatment) {
            $treatment->update_user_id = auth()->check() ? auth()->user()->id : null;
            $treatment->timestamps = false; // temporarily disable auto-timestamp update
            $treatment->updated_at = now(); // Set "updated_at" to current timestamp
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
    public function prescriptionTreatment(): HasOne
    {
        return $this->hasOne(PrescriptionTreatment::class);
    }

    // public function materialTreatment() : HasMany
    // {
    //     return $this->hasMany(MaterialTreatment::class);
    // }

    public function materials() : BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'material_treatment')->withPivot('total_cost', 'material_quantity')->withTimestamps();
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
