<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo,
    Relations\HasMany,
    Relations\HasOne,
};

class Prescription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new prescription
        static::creating(function ($prescription)  {
            $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
            $authUserEmail = auth()->user()->email;
            $prescription->create_doctor_id = auth()->check() && (auth()->user()->user_type == "doctor" || in_array($authUserEmail, $allowedUsersEmails)) ? auth()->user()->id : random_int(1, 2); // random_int() is the default value of the create user with id 1 to 2 randomly (this is used when submitting rows from the PrescriptionSeeder.php)
            $prescription->update_doctor_id = null; // Set to null to avoid accidental updates
            $prescription->created_at = now(); // Set "created_at" to current timestamp
            $prescription->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing prescription
        static::updating(function ($prescription) {
            $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "codexsoftwareservices01@gmail.com"];
            $authUserEmail = auth()->user()->email;
            $prescription->update_doctor_id = auth()->check() && (auth()->user()->user_type == "doctor" || in_array($authUserEmail, $allowedUsersEmails)) ? auth()->user()->id : null;
            $prescription->timestamps = false; // temporarily disable auto-timestamp update
            $prescription->updated_at = now(); // Set "updated_at" to current timestamp
        });
    }

    // Relationships
    public function create_doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'create_doctor_id', 'id');
    }

    public function update_doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'update_doctor_id', 'id');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function treatment(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }

    public function medicalHistory(): HasOne
    {
        return $this->hasOne(MedicalHistory::class);
    }

}
