<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookWrittenContent extends Model
{
    protected $fillable = [
        'book_chapter_id',
        'title_bn',
        'content_type',
        'question_bn',
        'content_bn',
        'marks',
        'bcs_reference',
        'order',
    ];

    protected $casts = [
        'marks' => 'decimal:1',
        'order' => 'integer',
    ];

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(BookChapter::class, 'book_chapter_id');
    }
}
