<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleGeneration extends Model
{
    protected $fillable = [
        'vehicle_model_id',
        'name',
        'start_year',
        'end_year',
    ];

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function engineVariants(): HasMany
    {
        return $this->hasMany(EngineVariant::class);
    }
}
