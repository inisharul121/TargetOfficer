<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Book extends Model
{
    protected $fillable = [
        'exam_type_id',
        'subject_id',
        'title_bn',
        'title_en',
        'slug',
        'description_bn',
        'cover_theme',
        'icon',
        'edition',
        'order',
        'is_published',
        'is_premium',
    ];

    protected $casts = [
        'order' => 'integer',
        'is_published' => 'boolean',
        'is_premium' => 'boolean',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function examType(): BelongsTo
    {
        return $this->belongsTo(ExamType::class);
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(BookChapter::class)->orderBy('chapter_number');
    }

    public function writtenContents(): HasManyThrough
    {
        return $this->hasManyThrough(BookWrittenContent::class, BookChapter::class);
    }
}
