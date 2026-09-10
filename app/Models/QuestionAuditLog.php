<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionAuditLog extends Model
{
    protected $fillable = [
        'question_id',
        'user_id',
        'action_type',
        'old_values',
        'new_values',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
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
