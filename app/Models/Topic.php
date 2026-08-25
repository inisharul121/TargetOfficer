<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    protected $fillable = [
        'subject_id',
        'name_en',
        'name_bn',
        'slug',
        'order',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function subtopics(): HasMany
    {
        return $this->hasMany(Subtopic::class)->orderBy('order');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
