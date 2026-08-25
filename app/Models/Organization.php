<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'name_en',
        'name_bn',
        'slug',
        'code',
        'is_question_setter',
        'description',
    ];

    protected $casts = [
        'is_question_setter' => 'boolean',
    ];

    public function examTypes(): HasMany
    {
        return $this->hasMany(ExamType::class);
    }

    public function setterQuestions(): HasMany
    {
        return $this->hasMany(Question::class, 'setter_organization_id');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
