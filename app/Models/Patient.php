<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo,
    Relations\HasMany
};

class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new patient
        static::creating(function ($patient) {
            $patient->create_user_id = auth()->check() ? auth()->user()->id : random_int(1, 2);
            $patient->update_user_id = null; // Set to null to avoid accidental updates
            $patient->created_at = now(); // Set "created_at" to current timestamp
            $patient->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing patient
        static::updating(function ($patient) {
            $patient->update_user_id = auth()->check() ? auth()->user()->id : null;
            $patient->timestamps = false; // temporarily disable auto-timestamp update
            $patient->updated_at = now(); // Set "updated_at" to current timestamp
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

    public function lastVisits(): HasMany
    {
        return $this->hasMany(LastVisit::class)->latest();
    }

    public function xray(): HasMany
    {
        return $this->hasMany(XRay::class);
    }

    public function analysis() : HasMany
    {
        return $this->hasMany(Analysis::class);
    }

    public function appointment() : HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function payment() : HasMany
    {
        return $this->hasMany(Payment::class);
    }

}
