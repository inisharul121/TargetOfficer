<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'exam_id',
        'status',
        'total_score',
        'total_correct',
        'total_incorrect',
        'total_unanswered',
        'total_negative_marks',
        'accuracy_percentage',
        'percentile_rank',
        'time_taken_seconds',
        'started_at',
        'completed_at',
        'tab_switch_count',
        'answers_state',
    ];

    protected $casts = [
        'total_score' => 'decimal:2',
        'total_negative_marks' => 'decimal:2',
        'accuracy_percentage' => 'decimal:2',
        'percentile_rank' => 'decimal:2',
        'total_correct' => 'integer',
        'total_incorrect' => 'integer',
        'total_unanswered' => 'integer',
        'time_taken_seconds' => 'integer',
        'tab_switch_count' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'answers_state' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class, 'attempt_id');
    }
}
