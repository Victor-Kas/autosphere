<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class BreakdownSolution extends Model
{
    protected $fillable = [
        'breakdown_id',
        'user_id',
        'body',
        'is_accepted'
    ];

    public function breakdown(): BelongsTo
    {
        return $this->belongsTo(Breakdown::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
