<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRoutineProgress extends Model
{
    protected $table = 'user_routine_progress';

    protected $fillable = [
        'user_id',
        'study_routine_id',
        'completed_date',
    ];

    protected $casts = [
        'completed_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function routine(): BelongsTo
    {
        return $this->belongsTo(StudyRoutine::class, 'study_routine_id');
    }
}
