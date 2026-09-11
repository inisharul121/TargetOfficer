<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudyRoutine extends Model
{
    protected $fillable = [
        'day_of_week',
        'day_name_bn',
        'day_name_en',
        'subject_id',
        'topic_title_bn',
        'topic_title_en',
        'syllabus_details_bn',
        'target_minutes',
        'target_questions',
        'is_active',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'target_minutes' => 'integer',
        'target_questions' => 'integer',
        'is_active' => 'boolean',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserRoutineProgress::class);
    }
}
