<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    Relations\BelongsTo
};

class Receipt extends Model
{
    use HasFactory;

    protected $table = "receipts";

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Event listener for creating a new receipt
        static::creating(function ($receipt) {
            $receipt->create_user_id = auth()->check() ? auth()->user()->id : random_int(1, 2);
            $receipt->update_user_id = null; // Set to null to avoid accidental updates
            $receipt->created_at = now(); // Set "created_at" to current timestamp
            $receipt->updated_at = null; // Set "updated_at" to null
        });

        // Event listener for updating an existing receipt
        static::updating(function ($receipt) {
            $receipt->update_user_id = auth()->check() ? auth()->user()->id : null;
            $receipt->timestamps = false; // temporarily disable auto-timestamp update
            $receipt->updated_at = now(); // Set "updated_at" to current timestamp
        });
    }

    // Relationships
    public function create_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'create_user_id', 'id');
    }

    public function update_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'update_user_id', 'id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
