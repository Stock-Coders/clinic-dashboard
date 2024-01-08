<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\HasOne,
    Relations\HasMany
};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    // Removing the default timestamps columns ("created_at" and "updated_at") from the table
    public $timestamps = false;

    // Setting a new timestamps criteria
    // protected static function booted()
    // {
    //     // The booted method is used to register an event listener for the creating event. This listener will be called when a new user is being created.
    //     static::creating(function ($user) {
    //         $user->registration_date = now();
    //     });

    //     // The booted method is used to register an event listener for the updating event. This listener will be called when an existing user is being updated, which includes cases when a user logs in.
    //     static::updating(function ($user) {
    //         $user->last_login_date = now();
    //     });
    // }

    //Relationships
    public function userProfile() : HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    // public function patient() : HasMany
    // {
    //     return $this->hasMany(Patient::class);
    // }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
