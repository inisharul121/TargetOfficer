<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionComment extends Model
{
    protected $fillable = [
        'question_id',
        'user_id',
        'comment',
        'is_solution_clarification',
        'upvotes_count',
    ];

    protected $casts = [
        'is_solution_clarification' => 'boolean',
        'upvotes_count' => 'integer',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
