<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    protected $fillable = [
        'user_id',
        'weekly_budget',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
