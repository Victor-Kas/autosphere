<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleModel extends Model
{
    protected $fillable = [
        'vehicle_make_id',
        'name',
        'slug',
    ];

    public function vehicleMake(): BelongsTo
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function generations(): HasMany
    {
        return $this->hasMany(VehicleGeneration::class);
    }

    public function breakdowns(): HasMany
    {
        return $this->hasMany(Breakdown::class);
    }    
}
