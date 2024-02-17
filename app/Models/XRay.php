<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo,
    Relations\HasOne
};

class XRay extends Model
{
    use HasFactory;

    protected $table = "xrays";

    protected $guarded = [];

    // For addressing the id of the author who created or updated an x-ray
    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new x-ray
        static::creating(function ($xray) {
            $xray->create_user_id = auth()->check() ? auth()->user()->id : random_int(1, 2); // random_int() is the default value of the create user with id 1 to 2 randomly (this is used when submitting rows from the XRaySeeder.php)
            $xray->update_user_id = null; // Set to null to avoid accidental updates
            $xray->created_at = now(); // Set "created_at" to current timestamp
            $xray->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing x-ray
        static::updating(function ($xray) {
            $xray->update_user_id = auth()->check() ? auth()->user()->id : null;
            $xray->timestamps = false; // temporarily disable auto-timestamp update
            $xray->updated_at = now(); // Set "updated_at" to current timestamp
        });
    }

    // Relationships
    public function create_user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'create_user_id', 'id');
    }

    public function update_user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'update_user_id', 'id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    // public function payment(): HasOne
    // {
    //     return $this->hasOne(Payment::class);
    // }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'payment_xray', 'xray_id', 'payment_id')->withTimestamps();
    }
}
