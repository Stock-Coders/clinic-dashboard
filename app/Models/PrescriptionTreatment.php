<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo,
    Relations\HasOne
};

class PrescriptionTreatment extends Model
{
    use HasFactory;

    protected $table = "prescriptions_treatments";

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new prescription treatment
        static::creating(function ($prescriptionTreatment)  {
            $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
            $authUserEmail = auth()->user()->email;
            $prescriptionTreatment->create_doctor_id = auth()->check() && (auth()->user()->user_type == "doctor" || in_array($authUserEmail, $allowedUsersEmails)) ? auth()->user()->id : random_int(1, 2); // random_int() is the default value of the create user with id 1 to 2 randomly (this is used when submitting rows from the PrescriptionTreatmentSeeder.php)
            $prescriptionTreatment->update_doctor_id = null; // Set to null to avoid accidental updates
            $prescriptionTreatment->created_at = now(); // Set "created_at" to current timestamp
            $prescriptionTreatment->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing prescription treatment
        static::updating(function ($prescriptionTreatment) {
            $allowedUsersEmails = ["doctor1@gmail.com", "doctor2@gmail.com", "kareemtarekpk@gmail.com", "mr.hatab055@gmail.com", "stockcoders99@gmail.com"];
            $authUserEmail = auth()->user()->email;
            $prescriptionTreatment->update_doctor_id = auth()->check() && (auth()->user()->user_type == "doctor" || in_array($authUserEmail, $allowedUsersEmails)) ? auth()->user()->id : null;
            $prescriptionTreatment->timestamps = false; // temporarily disable auto-timestamp update
            $prescriptionTreatment->updated_at = now(); // Set "updated_at" to current timestamp
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

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
    }

    public function medicalHistory(): HasOne
    {
        return $this->hasOne(MedicalHistory::class);
    }

}
