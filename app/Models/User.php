<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo,
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

    // For addressing the id of the author who created or updated a user
    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new user
        static::creating(function ($user) {
            $user->registration_datetime = \Carbon\Carbon::now(); // When a user (object) is being created (instantiated) the "registration_datetime" will be automatically the specified value
            $user->create_user_id = auth()->check() ? auth()->user()->id : null;
            $user->update_user_id = null; // Set to null to avoid accidental updates
            $user->created_at = now(); // Set "created_at" to current timestamp
            $user->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing user
        static::updating(function ($user) {
            $user->update_user_id = auth()->check() ? auth()->user()->id : null;
            $user->timestamps = false; // temporarily disable auto-timestamp update
            $user->updated_at = now(); // Set "updated_at" to current timestamp
        });
    }

    // scope to filter users by type (e.g. User::ofType('doctor')->get();)
    public function scopeOfType($query, $type)
    {
        return $query->where('user_type', $type);
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

    public function profile() : HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function patient() : HasMany
    {
        return $this->hasMany(Patient::class);
    }

    public function representative() : HasMany
    {
        return $this->hasMany(Representative::class);
    }

    public function material() : HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function prescription() : HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function analysis() : HasMany
    {
        return $this->hasMany(Analysis::class);
    }

    public function payment() : HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function contact() : HasMany
    {
        return $this->hasMany(Contact::class);
    }

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
