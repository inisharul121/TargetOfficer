<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamYear extends Model
{
    protected $fillable = [
        'name_en',
        'name_bn',
        'year',
    ];

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
