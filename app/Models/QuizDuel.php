<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizDuel extends Model
{
    protected $fillable = [
        'duel_code',
        'subject_id',
        'creator_id',
        'opponent_id',
        'status',
        'question_ids',
        'creator_score',
        'creator_time_seconds',
        'creator_completed_at',
        'opponent_score',
        'opponent_time_seconds',
        'opponent_completed_at',
        'winner_id',
    ];

    protected $casts = [
        'question_ids' => 'array',
        'creator_score' => 'decimal:2',
        'creator_time_seconds' => 'integer',
        'creator_completed_at' => 'datetime',
        'opponent_score' => 'decimal:2',
        'opponent_time_seconds' => 'integer',
        'opponent_completed_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function opponent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opponent_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
