<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamQuestion extends Model
{
    protected $fillable = [
        'exam_id',
        'question_id',
        'exam_section_id',
        'marks',
        'negative_marks',
        'order',
    ];

    protected $casts = [
        'marks' => 'decimal:2',
        'negative_marks' => 'decimal:2',
        'order' => 'integer',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function examSection(): BelongsTo
    {
        return $this->belongsTo(ExamSection::class);
    }
}
