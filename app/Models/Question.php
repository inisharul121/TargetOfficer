<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'subject_id',
        'topic_id',
        'subtopic_id',
        'setter_organization_id',
        'stem_bn',
        'stem_en',
        'question_type',
        'difficulty',
        'default_marks',
        'negative_marks',
        'explanation_bn',
        'explanation_en',
        'reference_source',
        'status',
        'created_by',
        'verified_by',
        'times_served',
        'times_correct',
        'accuracy_rate',
    ];

    protected $casts = [
        'default_marks' => 'decimal:2',
        'negative_marks' => 'decimal:2',
        'accuracy_rate' => 'decimal:2',
        'times_served' => 'integer',
        'times_correct' => 'integer',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function subtopic(): BelongsTo
    {
        return $this->belongsTo(Subtopic::class);
    }

    public function setterOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'setter_organization_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class)->orderBy('order');
    }

    public function correctOptions(): HasMany
    {
        return $this->hasMany(QuestionOption::class)->where('is_correct', true);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(QuestionTag::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(QuestionReport::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function recordAttempt(bool $isCorrect): void
    {
        $this->increment('times_served');
        if ($isCorrect) {
            $this->increment('times_correct');
        }
        $this->accuracy_rate = ($this->times_correct / max(1, $this->times_served)) * 100;
        $this->save();
    }
}
