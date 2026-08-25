<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamType extends Model
{
    protected $fillable = [
        'organization_id',
        'name_en',
        'name_bn',
        'slug',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
