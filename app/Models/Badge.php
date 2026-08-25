<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Badge extends Model
{
    protected $fillable = [
        'name_bn',
        'name_en',
        'code',
        'icon',
        'description_bn',
        'reward_coins',
    ];

    protected $casts = [
        'reward_coins' => 'integer',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badges')->withPivot('awarded_at');
    }
}
