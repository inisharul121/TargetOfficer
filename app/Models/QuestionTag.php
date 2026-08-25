<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionTag extends Model
{
    protected $fillable = [
        'question_id',
        'tag_type',
        'tag_value',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
