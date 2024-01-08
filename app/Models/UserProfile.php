<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo
};

class UserProfile extends Model
{
    use HasFactory;

    protected $table = "users_profiles";

    protected $guarded = [];

    //Relationships
    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id', 'id');
    }
}
