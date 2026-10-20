<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EngineVariant extends Model
{
    protected $fillable = [
        'vehicle_generation_id',
        'name',
        'engine_code',
        'fuel_type',
    ];

    public function vehicleGeneration(): BelongsTo
    {
        return $this->belongsTo(VehicleGeneration::class);
    }

    public function breakdowns(): HasMany
    {
        return $this->hasMany(Breakdown::class);
    }    
}
