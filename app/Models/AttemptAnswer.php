<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttemptAnswer extends Model
{
    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_option_id',
        'is_correct',
        'marks_awarded',
        'time_spent_seconds',
        'is_marked_for_review',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'is_marked_for_review' => 'boolean',
        'marks_awarded' => 'decimal:2',
        'time_spent_seconds' => 'integer',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class, 'attempt_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class, 'selected_option_id');
    }
}
