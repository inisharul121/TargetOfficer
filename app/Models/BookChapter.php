<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookChapter extends Model
{
    protected $fillable = [
        'book_id',
        'topic_id',
        'chapter_number',
        'title_bn',
        'title_en',
        'summary_bn',
        'order',
    ];

    protected $casts = [
        'chapter_number' => 'integer',
        'order' => 'integer',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function writtenContents(): HasMany
    {
        return $this->hasMany(BookWrittenContent::class)->orderBy('order');
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'book_chapter_questions')
            ->withPivot('order')
            ->orderBy('book_chapter_questions.order');
    }
}
