<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo
};

class Analysis extends Model
{
    use HasFactory;

    protected $table = "analyses";

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new analysis
        static::creating(function ($analysis) {
            $analysis->create_user_id = auth()->check() ? auth()->user()->id : random_int(1, 2);
            $analysis->update_user_id = null; // Set to null to avoid accidental updates
            $analysis->created_at = now(); // Set "created_at" to current timestamp
            $analysis->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing analysis
        static::updating(function ($analysis) {
            $analysis->update_user_id = auth()->check() ? auth()->user()->id : null;
            $analysis->timestamps = false; // temporarily disable auto-timestamp update
            $analysis->updated_at = now(); // Set "updated_at" to current timestamp
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

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

}
