<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo
};

class Contact extends Model
{
    use HasFactory;

    protected $table = "contacts";

    protected $guarded = [];

    // Relationships
    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class, 'create_user_id', 'id');
    }
}
