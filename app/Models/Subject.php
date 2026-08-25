<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'name_en',
        'name_bn',
        'slug',
        'icon',
        'color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class)->orderBy('order');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
