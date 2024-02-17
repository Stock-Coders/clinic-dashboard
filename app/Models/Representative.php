<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo,
    Relations\HasMany
};

class Representative extends Model
{
    use HasFactory;

    protected $guarded = [];

    // For addressing the id of the author who created or updated a representative
    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new representative
        static::creating(function ($representative) {
            $representative->create_user_id = auth()->check() ? auth()->user()->id : random_int(1, 2); // random_int() is the default value of the create user with id 1 to 2 randomly (this is used when submitting rows from the RepresentativeSeeder.php)
            $representative->update_user_id = null; // Set to null to avoid accidental updates
            $representative->created_at = now(); // Set "created_at" to current timestamp
            $representative->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing representative
        static::updating(function ($representative) {
            $representative->update_user_id = auth()->check() ? auth()->user()->id : null;
            $representative->timestamps = false; // temporarily disable auto-timestamp update
            $representative->updated_at = now(); // Set "updated_at" to current timestamp
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

    public function material() : HasMany
    {
        return $this->hasMany(Material::class);
    }
}
