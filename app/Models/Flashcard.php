<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flashcard extends Model
{
    protected $fillable = [
        'category',
        'category_bn',
        'subject_id',
        'front_bn',
        'front_en',
        'back_bn',
        'hint_bn',
        'source_tag',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserFlashcardProgress::class);
    }
}
