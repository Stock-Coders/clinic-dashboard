<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo
};

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relationships
    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
