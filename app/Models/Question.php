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

    public function exams(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Exam::class, 'exam_questions')->withPivot(['marks', 'negative_marks', 'order'])->orderBy('exam_questions.order');
    }

    /**
     * Get all structured source references for this question (exams, setter org, tags)
     */
    public function getSourcesAttribute(): array
    {
        $sources = [];

        // 1. Linked Exams (e.g. 10th BCS, 11th BCS, etc.)
        if ($this->relationLoaded('exams')) {
            $examList = $this->exams;
        } else {
            $examList = $this->exams()->with('examYear')->get();
        }

        foreach ($examList as $exam) {
            $title = $exam->examYear 
                ? str_replace('১০তম', '১০ম', $exam->examYear->name_bn)
                : trim(preg_replace('/\s*(প্রশ্ন\s*সমাধান|মডেল\s*টেস্ট).*$/u', '', $exam->title_bn));

            $sources[] = [
                'type' => 'exam',
                'title' => $title,
                'full_title' => $exam->title_bn,
                'slug' => $exam->slug,
                'url' => route('practice.index', ['exam' => $exam->slug]),
                'badge_color' => 'bg-amber-50 text-amber-800 border-amber-300 hover:bg-amber-100 hover:border-amber-400',
                'icon' => '🎓',
            ];
        }

        // 2. Setter Organization (e.g. BPSC, BUET, IBA)
        if ($this->setterOrganization) {
            $code = $this->setterOrganization->code ?: $this->setterOrganization->name_bn;
            $sources[] = [
                'type' => 'setter',
                'title' => $code,
                'full_title' => $this->setterOrganization->name_bn . ($this->setterOrganization->code ? " ({$this->setterOrganization->code})" : ''),
                'slug' => $this->setterOrganization->slug,
                'url' => route('practice.index', ['setter' => $this->setterOrganization->slug]),
                'badge_color' => 'bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100 hover:border-indigo-300',
                'icon' => '🏛️',
            ];
        }

        // 3. Additional Tags (e.g. other exams, repetitions, patterns)
        $tagList = $this->relationLoaded('tags') ? $this->tags : $this->tags()->get();
        foreach ($tagList as $tag) {
            if ($tag->tag_type === 'year') {
                continue; // Year is already captured in the exam context
            }

            // Check if already represented in exams
            $isDuplicate = collect($sources)->contains(function ($s) use ($tag) {
                return $s['type'] === 'exam' && (
                    str_contains($s['title'], $tag->tag_value) || 
                    str_contains($s['full_title'], $tag->tag_value) ||
                    str_contains($tag->tag_value, '10th') && str_contains($s['title'], '১০') ||
                    str_contains($tag->tag_value, '11th') && str_contains($s['title'], '১১')
                );
            });

            if (!$isDuplicate) {
                $sources[] = [
                    'type' => 'tag',
                    'title' => $tag->tag_value,
                    'full_title' => $tag->tag_value,
                    'slug' => $tag->tag_value,
                    'url' => route('practice.index', ['tag' => $tag->tag_value]),
                    'badge_color' => 'bg-sky-50 text-sky-700 border-sky-200 hover:bg-sky-100 hover:border-sky-300',
                    'icon' => '🏷️',
                ];
            }
        }

        return $sources;
    }

    public function reports(): HasMany
    {
        return $this->hasMany(QuestionReport::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(QuestionComment::class)->latest();
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(QuestionAuditLog::class)->latest();
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
