<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $fillable = [
        'title_bn',
        'title_en',
        'slug',
        'description_bn',
        'description_en',
        'exam_mode',
        'organization_id',
        'exam_type_id',
        'exam_year_id',
        'total_questions',
        'total_marks',
        'duration_minutes',
        'pass_percentage',
        'negative_mark_per_question',
        'is_published',
        'is_premium',
        'allow_pause',
        'shuffle_questions',
        'shuffle_options',
        'show_instant_result',
        'scheduled_start_at',
        'scheduled_end_at',
        'created_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_premium' => 'boolean',
        'allow_pause' => 'boolean',
        'shuffle_questions' => 'boolean',
        'shuffle_options' => 'boolean',
        'show_instant_result' => 'boolean',
        'total_questions' => 'integer',
        'total_marks' => 'decimal:2',
        'pass_percentage' => 'decimal:2',
        'negative_mark_per_question' => 'decimal:2',
        'duration_minutes' => 'integer',
        'scheduled_start_at' => 'datetime',
        'scheduled_end_at' => 'datetime',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function examType(): BelongsTo
    {
        return $this->belongsTo(ExamType::class);
    }

    public function examYear(): BelongsTo
    {
        return $this->belongsTo(ExamYear::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(ExamSection::class)->orderBy('order');
    }

    public function examQuestions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class)->orderBy('order');
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'exam_questions')
            ->withPivot(['exam_section_id', 'marks', 'negative_marks', 'order'])
            ->withTimestamps()
            ->orderByPivot('order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
