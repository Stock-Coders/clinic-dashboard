<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PaymentXRay extends Pivot
{
    protected $table = "payment_xray";

    // Removing the default timestamps columns ("created_at" and "updated_at") from the table
    // public $timestamps = false;
}
