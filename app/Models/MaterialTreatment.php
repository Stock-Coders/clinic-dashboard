<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MaterialTreatment extends Pivot
{
    protected $table = "material_treatment";

    protected $fillable = ['total_cost', 'material_quantity'];

    // Removing the default timestamps columns ("created_at" and "updated_at") from the table
    // public $timestamps = false;
}
