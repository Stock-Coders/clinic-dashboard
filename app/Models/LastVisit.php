<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo
};

class LastVisit extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Removing the default timestamps columns ("created_at" and "updated_at") from the table
    public $timestamps = false;

    protected $table = "last_visits";

    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new last visit
        static::creating(function ($patient) {
            $patient->create_user_id = auth()->check() ? auth()->user()->id : random_int(1, 2); // random_int() is the default value of the create user with id 1 to 2 randomly (this is used when submitting rows from the LastVisitSeeder.php)
        });
    }

    // Relationships
    public function create_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'create_user_id', 'id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}
