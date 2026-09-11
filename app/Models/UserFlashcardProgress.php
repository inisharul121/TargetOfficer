<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFlashcardProgress extends Model
{
    protected $table = 'user_flashcard_progress';

    protected $fillable = [
        'user_id',
        'flashcard_id',
        'is_mastered',
        'review_count',
        'last_reviewed_at',
    ];

    protected $casts = [
        'is_mastered' => 'boolean',
        'review_count' => 'integer',
        'last_reviewed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function flashcard(): BelongsTo
    {
        return $this->belongsTo(Flashcard::class);
    }
}
