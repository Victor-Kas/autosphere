<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Breakdown extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_model_id',
        'engine_variant_id',
        'title',
        'description',
        'mileage',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function engineVariant(): BelongsTo
    {
        return $this->belongsTo(EngineVariant::class);
    }

    public function solutions(): HasMany
    {
        return $this->hasMany(BreakdownSolution::class);
    }
}