<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentAffair extends Model
{
    protected $fillable = [
        'title_bn',
        'title_en',
        'category',
        'category_bn',
        'month_key',
        'summary_bn',
        'details_bn',
        'published_date',
        'is_featured',
        'mini_quiz',
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_featured' => 'boolean',
        'mini_quiz' => 'array',
    ];
}
