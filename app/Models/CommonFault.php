<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CommonFault extends Model
{
    protected $fillable = [
        'vehicle_model_id',
        'engine_variant_id',
        'title',
        'symptoms',
        'possible_causes',
        'recommended_repair',
        'verification_status',
    ];

    public function vehicleModel(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function engineVariant(): BelongsTo
    {
        return $this->belongsTo(EngineVariant::class);
    }

    public function breakdowns(): BelongsToMany
    {
        return $this->belongsToMany(Breakdown::class)->withTimestamps();
    }
}