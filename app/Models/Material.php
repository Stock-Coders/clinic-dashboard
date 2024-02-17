<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo,
    Relations\BelongsToMany,
    // Relations\HasMany
};

class Material extends Model
{
    use HasFactory;

    protected $guarded = [];

    // For addressing the id of the author who created or updated a material
    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new material
        static::creating(function ($material) {
            $material->create_user_id = auth()->check() ? auth()->user()->id : random_int(1, 2); // random_int() is the default value of the create user with id 1 to 2 randomly (this is used when submitting rows from the MaterialSeeder.php)
            $material->update_user_id = null; // Set to null to avoid accidental updates
            $material->created_at = now(); // Set "created_at" to current timestamp
            $material->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing material
        static::updating(function ($material) {
            $material->update_user_id = auth()->check() ? auth()->user()->id : null;
            $material->timestamps = false; // temporarily disable auto-timestamp update
            $material->updated_at = now(); // Set "updated_at" to current timestamp
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

    public function representative() : BelongsTo
    {
        return $this->belongsTo(Representative::class, 'representative_id', 'id');
    }

    // public function materialTreatment() : HasMany
    // {
    //     return $this->hasMany(MaterialTreatment::class);
    // }

    public function treatments() : BelongsToMany
    {
        return $this->belongsToMany(Treatment::class, 'material_treatment')->withPivot('total_cost', 'material_quantity')->withTimestamps();
    }
}
