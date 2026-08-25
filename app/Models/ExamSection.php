<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSection extends Model
{
    protected $fillable = [
        'exam_id',
        'name_bn',
        'name_en',
        'duration_minutes',
        'order',
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'order' => 'integer',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function examQuestions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class);
    }
}
